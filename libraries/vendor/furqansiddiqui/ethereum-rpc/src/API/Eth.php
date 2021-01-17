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

namespace EthereumRPC\API;

use EthereumRPC\BcMath;
use EthereumRPC\EthereumRPC;
use EthereumRPC\Exception\GethException;
use EthereumRPC\Response\Block;
use EthereumRPC\Response\Transaction;
use EthereumRPC\Response\TransactionReceipt;

/**
 * Class Eth
 * @package EthereumRPC\API
 */
class Eth
{
    /** @var EthereumRPC */
    private $client;

    /**
     * Eth constructor.
     * @param EthereumRPC $ethereumRPC
     */
    public function __construct(EthereumRPC $ethereumRPC)
    {
        $this->client = $ethereumRPC;
    }

    /**
     * @return int
     * @throws GethException
     * @throws \EthereumRPC\Exception\ConnectionException
     * @throws \HttpClient\Exception\HttpClientException
     */
    public function blockNumber(): int
    {
        $request = $this->client->jsonRPC("eth_blockNumber");
        $blockNumber = $request->get("result");
        if (!is_string($blockNumber) || !preg_match('/^(0x)?[a-f0-9]{2,}$/', $blockNumber)) {
            throw GethException::unexpectedResultType("eth_blockNumber", "hexadec", gettype($blockNumber));
        }

        return hexdec($blockNumber);
    }

    /**
     * @return array
     * @throws GethException
     * @throws \EthereumRPC\Exception\ConnectionException
     * @throws \HttpClient\Exception\HttpClientException
     */
    public function accounts(): array
    {
        $request = $this->client->jsonRPC("eth_accounts");
        $list = $request->get("result");
        if (!is_array($list)) {
            throw GethException::unexpectedResultType("eth_accounts", "array", gettype($list));
        }

        return $list;
    }

    /**
     * @return array
     * @throws GethException
     * @throws \EthereumRPC\Exception\ConnectionException
     * @throws \HttpClient\Exception\HttpClientException
     */
    public function list(): array
    {
        return $this->accounts();
    }

    /**
     * @param int $number
     * @return Block
     * @throws GethException
     * @throws \EthereumRPC\Exception\ConnectionException
     * @throws \EthereumRPC\Exception\ResponseObjectException
     * @throws \HttpClient\Exception\HttpClientException
     */
    public function getBlock(?int $number = null): ?Block
    {
        $blockHex = $number ? '0x' . dechex($number) : "latest";
        $request = $this->client->jsonRPC("eth_getBlockByNumber", null, [$blockHex, false]);
        $block = $request->get("result");
        if (is_null($block)) {
            return null; // Block not found
        }

        if (!is_array($block)) {
            throw GethException::unexpectedResultType("eth_getBlockByNumber", "object", gettype($block));
        }

        return new Block($block);
    }

    /**
     * @param string $txId
     * @return Transaction
     * @throws GethException
     * @throws \EthereumRPC\Exception\ConnectionException
     * @throws \EthereumRPC\Exception\ResponseObjectException
     * @throws \HttpClient\Exception\HttpClientException
     */
    public function getTransaction(string $txId): Transaction
    {
        $request = $this->client->jsonRPC("eth_getTransactionByHash", null, [$txId]);
        $transaction = $request->get("result");
        if (!is_array($transaction)) {
            throw GethException::unexpectedResultType("eth_getTransactionByHash", "array", gettype($transaction));
        }

        return new Transaction($transaction);
    }

    /**
     * @param string $txId
     * @return TransactionReceipt
     * @throws GethException
     * @throws \EthereumRPC\Exception\ConnectionException
     * @throws \HttpClient\Exception\HttpClientException
     */
    public function getTransactionReceipt(string $txId): TransactionReceipt
    {
        $request = $this->client->jsonRPC("eth_getTransactionReceipt", null, [$txId]);
        $receipt = $request->get("result");
        if (!is_array($receipt)) {
            throw GethException::unexpectedResultType("getTransactionReceipt", "array", gettype($receipt));
        }

        return new TransactionReceipt($receipt);
    }

    /**
     * @param string $account
     * @param string $scope
     * @return string
     * @throws GethException
     * @throws \EthereumRPC\Exception\ConnectionException
     * @throws \HttpClient\Exception\HttpClientException
     */
    public function getBalance(string $account, string $scope = "latest"): string
    {
        $request = $this->client->jsonRPC("eth_getBalance", null, [$account, $scope]);
        $balance = $request->get("result");
        if (!is_string($balance) || !preg_match('/^(0x)?[a-f0-9]+$/', $balance)) {
            throw GethException::unexpectedResultType("eth_getBalance", "hexdec", gettype($balance));
        }

        $balance = strval(BcMath::HexDec($balance));
        return bcdiv($balance, bcpow("10", "18", 0), EthereumRPC::SCALE);
    }

    /**
     * @param string $from
     * @param string $to
     * @param string $ethAmount
     * @return string
     * @throws GethException
     * @throws \EthereumRPC\Exception\ConnectionException
     * @throws \HttpClient\Exception\HttpClientException
     */
    public function sendTransaction(string $from, string $to, string $ethAmount): string
    {
        $value = "0x" . BcMath::DecHex(bcmul($ethAmount, bcpow("10", "18"), 0));

        $transaction = [
            "from" => $from,
            "to" => $to,
            "value" => $value
        ];

        $request = $this->client->jsonRPC("eth_sendTransaction", null, [$transaction]);
        $send = $request->get("result");
        if (!is_string($send)) {
            throw GethException::unexpectedResultType("eth_sendTransaction", "string", gettype($send));
        }

        return $send;
    }
}
