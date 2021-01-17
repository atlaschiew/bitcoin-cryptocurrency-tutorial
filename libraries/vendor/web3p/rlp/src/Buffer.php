<?php

/**
 * This file is part of rlp package.
 * 
 * (c) Kuan-Cheng,Lai <alk03073135@gmail.com>
 * 
 * @author Peter Lai <alk03073135@gmail.com>
 * @license MIT
 */

namespace Web3p\RLP;

use InvalidArgumentException;
use ArrayAccess;

class Buffer implements ArrayAccess
{
    /**
     * data
     * 
     * @var array
     */
    protected $data = [];

    /**
     * encoding
     * 
     * @var string
     */
    protected $encoding = '';

    /**
     * construct
     * 
     * @param mixed $data
     * @param string $encoding the data encoding
     * @return void
     */
    public function __construct($data=[], string $encoding='utf8')
    {
        $this->encoding = strtolower($encoding);

        if ($data) {
            $this->data = $this->decodeToData($data);
        }
    }

    /**
     * offsetSet
     * 
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * offsetExists
     * 
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * offsetUnset
     * 
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * offsetGet
     * 
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * toString
     * 
     * @param string $encoding
     * @return string
     */
    public function toString(string $encoding='utf8')
    {
        $output = '';
        $input = $this->data;

        switch ($encoding) {
            case 'hex':
            foreach ($input as $data)  {
                $hex = dechex($data);

                // pad zero
                if ((strlen($hex) % 2) !== 0) {
                    $hex = '0' . $hex;
                }
                $output .= $hex;
            }
            break;
            case 'ascii':
            foreach ($input as $data)  {
                $output .= chr($data);
            }
            break;
            case 'utf8':
            // $length = count($input);

            // for ($i = array_keys($input)[0]; $i < $length; $i += 3) {
            //     $output .= chr($input[$i]) . chr($input[$i + 1]) . chr($input[$i + 2]);
            // }
            // change to bytes string
            foreach ($input as $data)  {
                $output .= chr($data);
            }
            break;
            default:
            throw new InvalidArgumentException('ToString encoding must be valid.');
            break;
        }
        return $output;
    }

    /**
     * length
     * 
     * @return int
     */
    public function length()
    {
        return count($this->data);
    }

    /**
     * concat
     * 
     * @param mixed $inputs
     * @return \RLP\Buffer
     */
    public function concat()
    {
        $inputs = func_get_args();

        foreach ($inputs as $input) {
            if (is_array($input)) {
                $input = new Buffer($input);
            }
            if ($input instanceof Buffer) {
                $length = $input->length();

                for ($i = 0; $i < $length; $i++) {
                    $this->data[] = $input[$i];
                }
            } else {
                throw new InvalidArgumentException('Input must be array or Buffer when call concat.');
            }
        }
        return $this;
    }

    /**
     * slice
     * 
     * @param int $start
     * @param mixed $end
     * @return \RLP\Buffer
     */
    public function slice(int $start=0, $end=null)
    {
        if ($end === null) {
            $end = $this->length();
        }
        if ($end > 0) {
            $end -= $start;
        } elseif ($end === 0) {
            return new Buffer([]);
        }
        $sliced = array_slice($this->data, $start, $end);
        return new Buffer($sliced);
    }

    /**
     * decodeToData
     * 
     * @param mixed $input
     * @return array
     */
    protected function decodeToData($input)
    {
        $output = [];

        if (is_array($input)) {
            $output = $this->arrayToData($input);
        } elseif (is_int($input)) {
            $output = $this->intToData($input);
        } elseif (is_numeric($input)) {
            $output = $this->numericToData($input);
        } elseif (is_string($input)) {
            $output = $this->stringToData($input, $this->encoding);
        }
        return $output;
    }

    /**
     * arrayToData
     * 
     * @param array $inputs
     * @return array
     */
    protected function arrayToData(array $inputs)
    {
        $output = [];

        foreach ($inputs as $input) {
            if (is_array($input)) {
                // throw exception, maybe support future
                // $output[] = $this->arrayToData($input);
                throw new InvalidArgumentException('Do not use multidimensional array.');
            } elseif (is_string($input)) {
                $output = array_merge($output, $this->stringToData($input, $this->encoding));
            } elseif (is_numeric($input)) {
                $output = array_merge($output, $this->numericToData($input));
            }
        }
        return $output;
    }

    /**
     * stringToData
     * 
     * @param string $input
     * @param string $encoding
     * @return array
     */
    protected function stringToData(string $input, string $encoding)
    {
        $output = [];

        switch ($encoding) {
            case 'hex':
            if (strpos($input, '0x') === 0) {
                // hex string
                $input = str_replace('0x', '', $input);
            }
            if (strlen($input) % 2 !== 0) {
                $input = '0' . $input;
            }
            // $splited = str_split($input, 2);

            // foreach ($splited as $data)  {
            //     $output[] = hexdec($data);
            // }
            $output = array_map('hexdec', str_split($input, 2));

            break;
            case 'ascii':
            $output = array_map('ord', str_split($input, 1));
            break;
            case 'utf8':
            $output = unpack('C*', $input);
            break;
            default:
            throw new InvalidArgumentException('StringToData encoding must be valid.');
            break;
        }
        return $output;
    }

    /**
     * numericToData
     * 
     * @param mixed $intput
     * @return array
     */
    protected function numericToData($intput)
    {
        $output = (int) $intput;

        return [$output];
    }

    /**
     * intToData
     * 
     * @param mixed $intput
     * @return array
     */
    protected function intToData($input)
    {
        return array_fill(0, $input, 0);
    }
}