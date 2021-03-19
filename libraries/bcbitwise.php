<?php
/**
 * EngineAPI Helper Functions - bcBitwise
 */

/**
 * Utility Class - bcmath bitwise implementation
 * 
 * This library provides arbitrary precision AND, OR, XOR, leftshift and rightshift for use with
 * PHP with the bcmath extension enabled.
 * 
 * @see http://www.nirvani.net/software/bc_bitwise/bc_bitwise-0.9.0.inc.php.asc
 * @package Helper Functions\bcBitwise
 */
class bcBitwise
{
    /**
     * MAX_BASE is the maximum base that can be represented in one byte on the host machine.
     * On most modern systems, this value can be 256, but if there are still any systems
     * with 7-bit bytes out there, you should use 128 for maximum portability.
     * @see self::bc2bin()
     * @see self::bin2bc()
     * @const
     */
    const MAX_BASE=128;

    /**
     * Class flag showing the existence of the bcmath PHP Extension
     * @see self::bcExists()
     * @var bool
     */
    public static $bcExists;

    // ============================================================================================

    /**
     * BCMath implementation of PHP's Bitwise AND
     * @param string $x
     * @param string $y
     * @return string
     * @static
     */
    public static function bcAND($x, $y)
    {
        self::bcExists();
        return self::__bitwise($x, $y, 'and');
    }

    /**
     * BCMath implementation of PHP's Bitwise OR
     * @param string $x
     * @param string $y
     * @return string
     * @static
     */
    public static function bcOR($x, $y)
    {
        self::bcExists();
        return self::__bitwise($x, $y, 'or');
    }

    /**
     * BCMath implementation of PHP's Bitwise XOR
     * @param string $x
     * @param string $y
     * @return string
     * @static
     */
    public static function bcXOR($x, $y)
    {
        self::bcExists();
        return self::__bitwise($x, $y, 'xor');
    }

    /**
     * BCMath implementation of PHP's Bitwise Left Shift (<<)
     * @param string $num
     * @param string $shift
     * @return string
     * @static
     */
    public static function bcLeftShift($num, $shift)
    {
        self::bcExists();
        bcscale(0);
        return bcmul($num, bcpow(2, $shift));
    }

    /**
     * BCMath implementation of PHP's Bitwise Right Shift (>>)
     * @param string $num
     * @param string $shift
     * @return string
     * @static
     */
    public static function bcRightShift($num, $shift)
    {
        self::bcExists();
        bcscale(0);
        return bcdiv($num, bcpow(2, $shift));
    }

    /**
     * Internal implementation of the bitwise operations.
     * (This is the guts of this utility class)
     *
     * @param string $x
     * @param string $y
     * @param string $op
     * @return string
     * @static
     */
    private static function __bitwise($x, $y, $op)
    {
        self::bcExists();

        $bx = self::bc2bin($x);
        $by = self::bc2bin($y);

        // Pad $bx and $by so that both are the same length.
        list($bx, $by) = self::equalBinPad($bx, $by);

        $ret = '';
        for($ix = 0; $ix < strlen($bx); $ix++){
            $xd = substr($bx, $ix, 1);
            $yd = substr($by, $ix, 1);
            switch($op){
                case 'and':
                    $ret .= $xd & $yd;
                    break;

                case 'or':
                    $ret .= $xd | $yd;
                    break;

                case 'xor':
                    $ret .= $xd ^ $yd;
                    break;
            }
        }

        return self::bin2bc($ret);
    }

    /**
     * Pad the operands on the most-significant end so they have the same number of bytes.
     *
     * @param string $x
     *        binary-format number as converted from decimal format with bc2bin()
     * @param string $y
     *        binary-format number as converted from decimal format with bc2bin()
     * @return array
     * @static
     */
    private static function equalBinPad($x, $y)
    {
        self::bcExists();

        $length = max(strlen($x), strlen($y));
        return array(self::fixedBinPad($x, $length), self::fixedBinPad($y, $length));
    }

    /**
     * Pad a binary number up to a certain length
     *
     * @param string $num
     *        The operand to be padded.
     * @param int $length
     *        The desired minimum length for $num
     * @return string
     * @static
     */
    private static function fixedBinPad($num, $length)
    {
        self::bcExists();

        $pad = '';
        for($ii = 0; $ii < $length - strlen($num); $ii++){
            $pad .= self::bc2bin('0');
        }
        return $pad.$num;
    }

    /**
     * Convert a decimal number to the internal binary format used by this library.
     * @param string $num
     * @return string
     * @static
     */
    private static function bc2bin($num)
    {
        self::bcExists();
        return self::dec2base($num, self::MAX_BASE);
    }

    /**
     * The reverse of self::bc2bin()
     * @param string $num
     * @return string
     * @static
     */
    private static function bin2bc($num)
    {
        self::bcExists();
        return self::base2dec($num, self::MAX_BASE);
    }

    /**
     * Convert a decimal value to any other base value
     * @param string $dec
     * @param string $base
     * @param bool $digits
     * @return string
     * @static
     */
    public static function dec2base($dec, $base, $digits = FALSE)
    {
        self::bcExists();

        if($base < 2 or $base > 256) die("Invalid Base: " . $base);
        bcscale(0);
        $value = "";
        if(!$digits) $digits = self::digits($base);
        while($dec > $base - 1){
            $rest = bcmod($dec, $base);
            $dec = bcdiv($dec, $base);
            $value = $digits[$rest] . $value;
        }
        $value = $digits[intval($dec)] . $value;
        return (string)$value;
    }

    /**
     * Convert another base value to its decimal value
     * @param string $value
     * @param string $base
     * @param bool $digits
     * @return string
     * @static
     */
    public static function base2dec($value, $base, $digits = FALSE)
    {
        self::bcExists();

        if($base < 2 or $base > 256) die("Invalid Base: " . $base);
        bcscale(0);
        if($base < 37) $value = strtolower($value);
        if(!$digits) $digits = self::digits($base);
        $size = strlen($value);
        $dec = "0";
        for($loop = 0; $loop < $size; $loop++){
            $element = strpos($digits, $value[$loop]);
            $power = bcpow($base, $size - $loop - 1);
            $dec = bcadd($dec, bcmul($element, $power));
        }
        return (string)$dec;
    }

    /**
     * The purpose of digits() function is to supply the characters that will be used as digits for the base you want.
     *
     * NOTE:
     * You can use any characters for that when you convert
     * to another base, but when you convert again to the decimal base, you need to use the
     * same characters or you will get another unexpected result.
     *
     * @param string $base
     * @return string
     * @static
     */
    public static function digits($base)
    {
        self::bcExists();

        if($base > 64){
            $digits = "";
            for($loop = 0; $loop < 256; $loop++){
                $digits .= chr($loop);
            }
        } else {
            $digits = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_";
        }
        $digits = substr($digits, 0, $base);
        return (string)$digits;
    }

    /**
     * Internal check for the existence of the bcmath extension
     * @static
     * @return bool
     */
    private static function bcExists()
    {
        if(self::$bcExists) return self::$bcExists;

        if(!extension_loaded('bcmath')){
            self::$bcExists = FALSE;
            exit("bcmath extention required\nFile: " . basename(__FILE__) . "\nLine: " . __LINE__ . "\n");
        } else {
            self::$bcExists = TRUE;
        }
        return self::$bcExists;
    }
}