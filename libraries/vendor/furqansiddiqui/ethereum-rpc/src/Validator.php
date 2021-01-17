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

namespace EthereumRPC;

/**
 * Class Validator
 * @package EthereumRPC
 */
class Validator
{
    /**
     * @param $addr
     * @return bool
     */
    public static function Address($addr): bool
    {
        return (is_string($addr) && preg_match('/^0x[a-f0-9]{40}$/i', $addr)) ? true : false;
    }

    /**
     * @param $amount
     * @param bool $signed
     * @return bool
     */
    public static function BcAmount($amount, bool $signed = false): bool
    {
        if (!is_string($amount)) {
            return false;
        }

        $pattern = '[0-9]+(\.[0-9]+)?';
        if ($signed) {
            $pattern = '\-?' . $pattern;
        }

        return preg_match('/^' . $pattern . '$/', $amount) ? true : false;
    }
}
