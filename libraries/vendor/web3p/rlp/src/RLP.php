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
use RuntimeException;
use Web3p\RLP\Buffer;

class RLP
{
    /**
     * encode
     * 
     * @param mixed $inputs array of string
     * @return \Web3p\RLP\Buffer
     */
    public function encode($inputs)
    {
        if (is_array($inputs)) {
            $output = new Buffer;
            $result = new Buffer;

            foreach ($inputs as $input) {
                $output->concat($this->encode($input));
            }
            return $result->concat($this->encodeLength($output->length(), 192), $output);
        }
        $output = new Buffer;
        $input = $this->toBuffer($inputs);
        $length = $input->length();

        if ($length === 1 && $input[0] < 128) {
            return $input;
        } else {
            return $output->concat($this->encodeLength($length, 128), $input);
        }
    }

    /**
     * decode
     * Maybe use bignumber future.
     * 
     * @param string $input
     * @return array
     */
    public function decode(string $input)
    {
        // if (!is_string($input)) {
        //     throw new InvalidArgumentException('Input must be string when call decode.');
        // }
        $input = $this->toBuffer($input);
        $decoded = $this->decodeData($input);

        return $decoded['data'];
    }

    /**
     * decodeData
     * Maybe use bignumber future.
     * 
     * @param \Web3p\RLP\Buffer $input
     * @return array
     */
    protected function decodeData(Buffer $input)
    {
        $firstByte = $input[0];
        $output = new Buffer;

        if ($firstByte <= 0x7f) {
            return [
                'data' => $input->slice(0, 1),
                'remainder' => $input->slice(1)
            ];
        } elseif ($firstByte <= 0xb7) {
            $length = $firstByte - 0x7f;
            $data = new Buffer([]);

            if ($firstByte !== 0x80) {
                // for ($i = 1; $i < $length; $i++) {
                //     $data[] = $input[$i];
                // }
                $data = $input->slice(1, $length);
            }
            if ($length === 2 && $data[0] < 0x80) {
                throw new RuntimeException('Byte must be less than 0x80.');
            }
            return [
                'data' => $data,
                'remainder' => $input->slice($length)
            ];
        } elseif ($firstByte <= 0xbf) {
            $llength = $firstByte - 0xb6;
            $hexLength = $input->slice(1, $llength)->toString('hex');

            if ($hexLength === '00') {
                throw new RuntimeException('Invalid RLP.');
            }
            $length = hexdec($hexLength);
            $data = $input->slice($llength, $length + $llength);

            if ($data->length() < $length) {
                throw new RuntimeException('Invalid RLP.');
            }
            return [
                'data' => $data,
                'remainder' => $input->slice($length + $llength)
            ];
        } elseif ($firstByte <= 0xf7) {
            $length = $firstByte - 0xbf;
            $innerRemainder = $input->slice(1, $length);
            $decoded = [];

            while ($innerRemainder->length()) {
                $data = $this->decodeData($innerRemainder);
                $decoded[] = $data['data'];
                $innerRemainder = $data['remainder'];
            }
            return [
                'data' => $decoded,
                'remainder' => $input->slice($length)
            ];
        } else {
            $llength = $firstByte - 0xf6;
            $hexLength = $input->slice(1, $llength)->toString('hex');
            $decoded = [];

            if ($hexLength === '00') {
                throw new RuntimeException('Invalid RLP.');
            }
            $length = hexdec($hexLength);
            $totalLength = $llength + $length;

            if ($totalLength > $input->length()) {
                throw new RuntimeException('Invalid RLP: total length is bigger than data length.');
            }
            $innerRemainder = $input->slice($llength, $totalLength);

            if ($innerRemainder->length() === 0) {
                throw new RuntimeException('Invalid RLP: list has invalid length.');
            }

            while ($innerRemainder->length()) {
                $data = $this->decodeData($innerRemainder);
                $decoded[] = $data['data'];
                $innerRemainder = $data['remainder'];
            }
            return [
                'data' => $decoded,
                'remainder' => $input->slice($length)
            ];
        }
    }

    /**
     * encodeLength
     * 
     * @param int $length
     * @param int $offset
     * @return \Web3p\RLP\Buffer
     */
    protected function encodeLength(int $length, int $offset)
    {
        // if (!is_int($length) || !is_int($offset)) {
        //     throw new InvalidArgumentException('Length and offset must be int when call encodeLength.');
        // }
        if ($length < 56) {
            // var_dump($length, $offset);
            return new Buffer(strval($length + $offset));
        }
        $hexLength = $this->intToHex($length);
        $firstByte = $this->intToHex($offset + 55 + (strlen($hexLength) / 2));
        return new Buffer(strval($firstByte . $hexLength), 'hex');
    }

    /**
     * intToHex
     * 
     * @param int $value
     * @return string
     */
    protected function intToHex(int $value)
    {
        // if (!is_int($value)) {
        //     throw new InvalidArgumentException('Value must be int when call intToHex.');
        // }
        $hex = dechex($value);

        return $this->padToEven($hex);
    }

    /**
     * padToEven
     * 
     * @param string $value
     * @return string
     */
    protected function padToEven(string $value)
    {
        // if (!is_string($value)) {
        //     throw new InvalidArgumentException('Value must be string when call padToEven.');
        // }
        if ((strlen($value) % 2) !== 0 ) {
            $value = '0' . $value;
        }
        return $value;
    }

    /**
     * toArray
     * Format input to value, deprecated when we have toBuffer.
     * 
     * @param mixed $input
     * @return array
     */
    // protected function toArray($input)
    // {
    //     if (is_string($input)) {
    //         if (strpos($input, '0x') === 0) {
    //             // hex string
    //             $value = str_replace('0x', '', $input);
    //             return $input;
    //         } else {
    //             return str_split($input, 1);
    //         }
    //     }
    //     throw new InvalidArgumentException('The input type didn\'t support.');
    // }

    /**
     * toBuffer
     * Format input to buffer.
     * 
     * @param mixed $input
     * @return \Web3p\RLP\Buffer
     */
    protected function toBuffer($input)
    {
        if (is_string($input)) {
            if (strpos($input, '0x') === 0) {
                // hex string
                // $input = str_replace('0x', '', $input);
                return new Buffer($input, 'hex');
            }
            return new Buffer(str_split($input, 1));
        } elseif (is_numeric($input)) {
            if (!$input || $input < 0) {
                return new Buffer([]);
            }
            if (is_float($input)) {
                $input = number_format($input, 0, '', '');
                var_dump($input);
            }
            $gmpInput = gmp_init($input, 10);
            return new Buffer('0x' . gmp_strval($gmpInput, 16), 'hex');
        } elseif ($input === null) {
            return new Buffer([]);
        } elseif (is_array($input)) {
            return new Buffer($input);
        } elseif ($input instanceof Buffer) {
            return $input;
        }
        throw new InvalidArgumentException('The input type didn\'t support.');
    }
}