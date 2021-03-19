<?php

/**
 * This file is part of rlp package.
 * 
 * (c) Kuan-Cheng,Lai <alk03073135@gmail.com>
 * 
 * @author Peter Lai <alk03073135@gmail.com>
 * @license MIT
 */

namespace Web3p\RLP\Types;

class Numeric
{
    /**
     * encode
     *
     * @param string $input
     * @return string encoded hex of input
     */
    static function encode(string $input)
    {
        if (!$input || $input < 0) {
            return '';
        }
        if (is_float($input)) {
            $input = number_format($input, 0, '', '');
        }
        $intInput = strval($input);
        $output = dechex($intInput);
        $outputLen = mb_strlen($output);
        if ($outputLen > 0 && $outputLen % 2 !== 0) {
            return '0' . $output;
        }
        return $output;
    }
}
