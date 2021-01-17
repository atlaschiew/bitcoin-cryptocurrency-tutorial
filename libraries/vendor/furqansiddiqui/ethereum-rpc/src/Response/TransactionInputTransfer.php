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

namespace EthereumRPC\Response;

use EthereumRPC\BcMath;
use EthereumRPC\Exception\ResponseObjectException;

/**
 * Class TransactionInput
 * @package EthereumRPC\Response
 */
class TransactionInputTransfer implements TransactionInputInterface
{
    /** @var string */
    public $payee;
    /** @var string */
    public $amount;

    /**
     * TransactionInputTransfer constructor.
     * @param string $input
     * @throws ResponseObjectException
     */
    public function __construct(string $input)
    {
        // Method
        $method = substr($input, 0, 10);
        if ($method !== '0xa9059cbb') {
            throw new ResponseObjectException('Cannot instantiate "TransactionInputTransfer" with invalid input type');
        }

        // Payee
        $payee = substr($input, 10, 64); // grab block of 64 bytes
        $payee = '0x' . substr($payee, 24); // grab last 40 bytes
        if (!preg_match('/^0x[a-f0-9]{40}$/', $payee)) {
            throw new ResponseObjectException('Invalid token transfer payee address');
        }

        $this->payee = $payee;

        // Amount
        $amount = substr($input, 74, 64); // grab second block of 64 bytes
        $amount = '0x' . $amount;

        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function wei(): string
    {
        return number_format(BcMath::HexDec($this->amount), 0, '.', '');
    }
}
