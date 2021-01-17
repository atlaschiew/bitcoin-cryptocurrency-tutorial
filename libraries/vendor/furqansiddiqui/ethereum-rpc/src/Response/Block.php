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

use EthereumRPC\Exception\ResponseObjectException;

/**
 * Class Block
 * @package EthereumRPC\Response
 */
class Block
{
    /** @var string|null */
    public $number;
    /** @var string|null */
    public $hash;
    /** @var string */
    public $parentHash;
    /** @var string */
    public $nonce;
    /** @var string */
    public $sha3Uncles;
    /** @var string */
    public $logsBloom;
    /** @var string */
    public $transactionsRoot;
    /** @var string */
    public $statesRoot;
    /** @var string */
    public $receiptsRoot;
    /** @var string */
    public $miner;
    /** @var string */
    public $difficulty;
    /** @var string */
    public $totalDifficulty;
    /** @var string */
    public $extraData;
    /** @var string */
    public $size;
    /** @var string */
    public $gasLimit;
    /** @var string */
    public $gasUsed;
    /** @var string */
    public $timestamp;
    /** @var array */
    public $transactions;
    /** @var array */
    public $uncles;

    /** @var int */
    private $_number;

    /**
     * Block constructor.
     * @param array $obj
     * @throws ResponseObjectException
     */
    public function __construct(array $obj)
    {
        $this->number = $obj["number"] ?? null;
        $this->hash = $obj["hash"] ?? null;
        if (is_string($this->number)) {
            $this->_number = hexdec($this->number);
        }

        if (!is_string($this->number) && !is_null($this->number)) {
            throw $this->unexpectedParamValue("number", "hexdec", gettype($this->number));
        }

        if (!is_string($this->hash) && !is_null($this->hash)) {
            throw $this->unexpectedParamValue("hash", "hash", gettype($this->hash));
        }

        // Hash strings
        $stringParams = [
            "parentHash",
            "nonce",
            "sha3Uncles",
            "logsBloom",
            "transactionsRoot",
            "stateRoot",
            "receiptsRoot",
            "miner",
            "difficulty",
            "totalDifficulty",
            "extraData",
            "size",
            "gasLimit",
            "gasUsed",
            "timestamp"
        ];

        foreach ($stringParams as $param) {
            $value = $obj[$param] ?? null;
            if (!is_string($value) || !preg_match('/^0x[a-f0-9]*$/i', $value)) {
                throw $this->unexpectedParamValue($param, "string", gettype($value));
            }

            $this->$param = $value;
        }
        unset($param, $value);

        // Uncles
        $this->uncles = $obj["uncles"] ?? null;
        if (!is_array($this->uncles)) {
            throw $this->unexpectedParamValue("uncles", "array", gettype($this->uncles));
        }

        // Transactions
        $this->transactions = $obj["transactions"] ?? null;
        if (!is_array($this->transactions)) {
            throw $this->unexpectedParamValue("transactions", "array", gettype($this->transactions));
        }
    }

    /**
     * @return int|null
     */
    public function number(): ?int
    {
        return $this->_number;
    }

    /**
     * @param string $param
     * @param null|string $expected
     * @param null|string $got
     * @return ResponseObjectException
     */
    private function unexpectedParamValue(string $param, ?string $expected = null, ?string $got = null): ResponseObjectException
    {
        $message = sprintf('Bad/unexpected value for param "%s"', $param);
        if ($expected) {
            $message .= sprintf(', expected "%s"', $expected);
        }

        if ($got) {
            $message .= sprintf(', got "%s"', $got);
        }


        return $this->exception($message);
    }

    /**
     * @param string $message
     * @return ResponseObjectException
     */
    private function exception(string $message): ResponseObjectException
    {
        $blockId = is_int($this->_number) ? $this->_number : "pending";
        return new ResponseObjectException(
            sprintf('Ethereum Block [%s]: %s', $blockId, $message)
        );
    }
}
