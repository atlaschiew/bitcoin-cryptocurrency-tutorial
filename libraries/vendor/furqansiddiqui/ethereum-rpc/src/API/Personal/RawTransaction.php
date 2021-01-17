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

namespace EthereumRPC\API\Personal;

use EthereumRPC\API\Personal;
use EthereumRPC\BcMath;
use EthereumRPC\Exception\RawTransactionException;
use EthereumRPC\Validator;

/**
 * Class RawTransaction
 * @package EthereumRPC\API\Personal
 * @property-read string $from
 * @property-read string $to
 * @property-read string $value
 * @property-read string $gas
 * @property-read string $gasPrice
 * @property-read string $data
 */
class RawTransaction
{
    /** @var Personal */
    private $_api;

    /** @var string */
    private $from;
    /** @var string */
    private $to;
    /** @var null|string */
    private $value;
    /** @var null|int */
    private $gas;
    /** @var null|string */
    private $gasPrice;
    /** @var null|string */
    private $data;

    /**
     * RawTransaction constructor.
     * @param Personal $api
     * @param string $from
     * @param string $to
     * @throws RawTransactionException
     */
    public function __construct(Personal $api, string $from, string $to)
    {
        if (!Validator::Address($from)) {
            throw new RawTransactionException('Invalid "from" Ethereum address');
        }

        if (!Validator::Address($to)) {
            throw new RawTransactionException('Invalid "to" Ethereum address');
        }

        $this->_api = $api;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @param string $prop
     * @return bool|int|null|string
     */
    public function __get(string $prop)
    {
        switch ($prop) {
            case "from":
                return $this->from;
            case "to":
                return $this->to;
            case "value":
                return "0x" . BcMath::DecHex(bcmul($this->value ?? "0", bcpow("10", "18"), 0)); // Convert ETH to WEI
            case "data":
                return $this->data;
            case "gas":
                return $this->gas;
            case "gasPrice":
                return $this->gasPrice;
            default:
                return false;
        }
    }

    /**
     * @param string $ethAmount
     * @return RawTransaction
     * @throws RawTransactionException
     */
    public function amount(string $ethAmount): self
    {
        if (!Validator::BcAmount($ethAmount)) {
            throw new RawTransactionException('Invalid transaction amount in ETH');
        }

        $this->value = $ethAmount;
        return $this;
    }

    /**
     * @param string $data
     * @return RawTransaction
     */
    public function data(string $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string $payee
     * @return RawTransaction
     * @throws RawTransactionException
     */
    public function to(string $payee): self
    {
        if (!Validator::Address($payee)) {
            throw new RawTransactionException('Invalid "to" Ethereum address');
        }

        $this->to = $payee;
        return $this;
    }

    /**
     * @param int|null $limit
     * @param string|null $gasPriceETH
     * @return RawTransaction
     * @throws RawTransactionException
     */
    public function gas(?int $limit = null, ?string $gasPriceETH = null): self
    {
        if ($limit) {
            $this->gas = $limit;
        }

        if ($gasPriceETH) {
            if (!Validator::BcAmount($gasPriceETH)) {
                throw new RawTransactionException('Invalid price per gas in ETH');
            }

            $this->gasPrice = $gasPriceETH;
        }

        return $this;
    }

    /**
     * @param string $password
     * @return string
     * @throws \EthereumRPC\Exception\ConnectionException
     * @throws \EthereumRPC\Exception\GethException
     * @throws \HttpClient\Exception\HttpClientException
     */
    public function send(string $password): string
    {
        return $this->_api->send($this, $password);
    }
}
