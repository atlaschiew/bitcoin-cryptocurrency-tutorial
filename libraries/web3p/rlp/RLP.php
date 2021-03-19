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
use Web3p\RLP\Types\Str;
use Web3p\RLP\Types\Numeric;

class RLP
{
    /**
     * encode
     *
     * @param mixed $inputs array of data
     * @return string
     */
    public function encode($inputs)
    {
        $output = '';
        if (is_array($inputs)) {
            foreach ($inputs as $input) {
                $output .= $this->encode($input);
            }
            $length = mb_strlen($output) / 2;
            return $this->encodeLength($length, 192) . $output;
        }
        $input = $this->encodeInput($inputs);
        $length = mb_strlen($input) / 2;

        if ($length === 1 && hexdec(mb_substr($input, 0, 2)) < 128) {
            return $input;
        }
        return $this->encodeLength($length, 128) . $input;
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
        if (strpos($input, '0x') === 0) {
            $input = str_replace('0x', '', $input);
        }
        if (!preg_match('/[a-f0-9]/i', $input)) {
            throw new InvalidArgumentException('The input type didn\'t support.');
        }
        $input = $this->padToEven($input);
        $decoded = $this->decodeData($input);
        return $decoded['data'];
    }

    /**
     * decodeData
     *
     * @param string $input
     * @return array
     */
    protected function decodeData(string $input)
    {
        $firstByte = hexdec(mb_substr($input, 0, 2));

        if ($firstByte <= 0x7f) {
            return [
                'data' => dechex($firstByte),
                'remainder' => mb_substr($input, 2)
            ];
        } elseif ($firstByte <= 0xb7) {
            $length = $firstByte - 0x7f;
            $data = '';

            if ($firstByte !== 0x80) {
                $data = mb_substr($input, 2, ($length - 1) * 2);
            }
            $firstByteData = hexdec(mb_substr($data, 0, 2));
            if ($length === 2 && $firstByteData < 0x80) {
                throw new RuntimeException('Byte must be less than 0x80.');
            }
            return [
                'data' => $data,
                'remainder' => mb_substr($input, $length * 2)
            ];
        } elseif ($firstByte <= 0xbf) {
            $llength = $firstByte - 0xb6;
            $hexLength = mb_substr($input, 2, ($llength - 1) * 2);

            if ($hexLength === '00') {
                throw new RuntimeException('Invalid RLP.');
            }
            $length = hexdec($hexLength);
            $data = mb_substr($input, $llength * 2, ($length + $llength - 1) * 2);

            if (mb_strlen($data) < $length * 2) {
                throw new RuntimeException('Invalid RLP.');
            }
            return [
                'data' => $data,
                'remainder' => mb_substr($input, ($length + $llength) * 2)
            ];
        } elseif ($firstByte <= 0xf7) {
            $length = $firstByte - 0xbf;
            $innerRemainder = mb_substr($input, 2, ($length - 1) * 2);
            $decoded = [];

            while (mb_strlen($innerRemainder)) {
                $data = $this->decodeData($innerRemainder);
                $decoded[] = $data['data'];
                $innerRemainder = $data['remainder'];
            }
            return [
                'data' => $decoded,
                'remainder' => mb_substr($input, $length * 2)
            ];
        } else {
            $llength = $firstByte - 0xf6;
            $hexLength = mb_substr($input, 2, ($llength - 1) * 2);
            $decoded = [];

            if ($hexLength === '00') {
                throw new RuntimeException('Invalid RLP.');
            }
            $length = hexdec($hexLength);
            $totalLength = $llength + $length;

            if ($totalLength * 2 > mb_strlen($input)) {
                throw new RuntimeException('Invalid RLP: total length is bigger than data length.');
            }
            $innerRemainder = $hexLength = mb_substr($input, $llength * 2, $totalLength * 2);

            if (mb_strlen($innerRemainder) === 0) {
                throw new RuntimeException('Invalid RLP: list has invalid length.');
            }

            while (mb_strlen($innerRemainder)) {
                $data = $this->decodeData($innerRemainder);
                $decoded[] = $data['data'];
                $innerRemainder = $data['remainder'];
            }
            return [
                'data' => $decoded,
                'remainder' => mb_substr($input, $length * 2)
            ];
        }
    }

    /**
     * encodeLength
     * 
     * @param int $length
     * @param int $offset
     * @return string
     */
    protected function encodeLength(int $length, int $offset)
    {
        if ($length < 56) {
            return dechex(strval($length + $offset));
        }
        $hexLength = $this->intToHex($length);
        $firstByte = $this->intToHex($offset + 55 + (strlen($hexLength) / 2));
        return $firstByte . $hexLength;
    }

    /**
     * intToHex
     * 
     * @param int $value
     * @return string
     */
    protected function intToHex(int $value)
    {
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
        if ((strlen($value) % 2) !== 0 ) {
            $value = '0' . $value;
        }
        return $value;
    }

    /**
     * encodeInput
     * Encode input to hex string.
     *
     * @param mixed $input
     * @return string
     */
    protected function encodeInput($input)
    {
        if (is_string($input)) {
            if (strpos($input, '0x') === 0) {
                return Str::encode($input, 'hex');
            }
            return Str::encode($input);
        } elseif (is_numeric($input)) {
            return Numeric::encode($input);
        } elseif ($input === null) {
            return '';
        }
        throw new InvalidArgumentException('The input type didn\'t support.');
    }
}