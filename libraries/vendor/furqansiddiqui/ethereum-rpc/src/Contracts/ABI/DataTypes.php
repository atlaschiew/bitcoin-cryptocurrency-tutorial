<?php
/**
 * This file is a part of "furqansiddiqui/ethereum-rpc" package.
 * https://github.com/furqansiddiqui/ethereum-rpc
 *
 * Copyright (c) 2020 Furqan A. Siddiqui <hello@furqansiddiqui.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or visit following link:
 * https://github.com/furqansiddiqui/ethereum-rpc/blob/master/LICENSE
 */

declare(strict_types=1);

namespace EthereumRPC\Contracts\ABI;

use EthereumRPC\BcMath;
use EthereumRPC\Exception\ContractABIException;
use EthereumRPC\Validator;

/**
 * Class ABI_Validator
 * @package EthereumRPC\Contracts\ABI
 */
class DataTypes
{
    /**
     * @param null|string $type
     * @param $value
     * @return bool
     * @throws ContractABIException
     */
    public static function Validate(string $type, $value): bool
    {
        $len = preg_replace('/[^0-9]/', '', $type);
        if (!$len) {
            $len = null;
        }
        $type = preg_replace('/[^a-z]/', '', $type);

        switch ($type) {
            case "hash":
                $len = $len ?? 64;
                return (is_string($value) && preg_match(sprintf('/^(0x)?[a-f0-9]{%d}$/', $len ?? 64), $value)) ?
                    true : false;
            case "address":
                return Validator::Address($value);
            case "uint":
            case "int":
                return is_int($value);
            case "bool":
                return is_bool($value);
            case "string":
                return is_string($value);
            default:
                throw new ContractABIException(sprintf('Cannot validate value of type "%s"', $type));
        }
    }

    /**
     * @param null|string $type
     * @param $value
     * @return string
     * @throws ContractABIException
     */
    public static function Encode(string $type, $value): string
    {
        $len = preg_replace('/[^0-9]/', '', $type);
        if (!$len) {
            $len = null;
        }
        $type = preg_replace('/[^a-z]/', '', $type);

        switch ($type) {
            case "hash":
            case "address":
                if (substr($value, 0, 2) === "0x") {
                    $value = substr($value, 2);
                }
                break;
            case "uint":
            case "int":
                $value = BcMath::DecHex($value);
                break;
            case "bool":
                $value = $value === true ? 1 : 0;
                break;
            case "string":
                $value = self::Str2Hex($value);
                break;
            default:
                throw new ContractABIException(sprintf('Cannot encode value of type "%s"', $type));
        }

        return substr(str_pad(strval($value), 64, "0", STR_PAD_LEFT), 0, 64);
    }

    /**
     * @param string $type
     * @param string $encoded
     * @return bool|float|int|string
     * @throws ContractABIException
     */
    public static function Decode(string $type, string $encoded)
    {
        $len = preg_replace('/[^0-9]/', '', $type);
        if (!$len) {
            $len = null;
        }
        $type = preg_replace('/[^a-z]/', '', $type);

        $encoded = ltrim($encoded, "0");
        switch ($type) {
            case "hash":
            case "address":
                return '0x' . $encoded;
            case "uint":
            case "int":
                return BcMath::HexDec($encoded);
            case "bool":
                return boolval($encoded);
            case "string":
                return self::Hex2Str($encoded);
            default:
                throw new ContractABIException(sprintf('Cannot encode value of type "%s"', $type));
        }
    }

    /**
     * @param string $str
     * @return string
     */
    public static function Str2Hex(string $str): string
    {
        $hex = "";
        for ($i = 0; $i < strlen($str); $i++) {
            $hex .= dechex(ord($str[$i]));
        }

        return $hex;
    }

    /**
     * @param string $hex
     * @return string
     */
    public static function Hex2Str(string $hex): string
    {
        $str = "";
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $str .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }

        return $str;
    }
}
