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
 * Class Transaction
 * @package EthereumRPC\Response
 */
class Transaction
{
    /** @var string */
    public $hash;
    /** @var string */
    public $nonce;
    /** @var null|string */
    public $blockHash;
    /** @var null|string */
    public $blockNumber;
    /** @var null|string */
    public $transactionIndex;
    /** @var string */
    public $from;
    /** @var string */
    public $to;
    /** @var string */
    public $value;
    /** @var string */
    public $gasPrice;
    /** @var string */
    public $gas;
    /** @var null|string */
    public $input;

    /** @var null|TransactionInputInterface */
    private $_input;

    /**
     * Transaction constructor.
     * @param array $obj
     * @throws ResponseObjectException
     */
    public function __construct(array $obj)
    {
        // Primary param
        $hash = $obj["hash"] ?? null;
        if (!is_string($hash) && !preg_match('/^0x[a-f0-9]{66}$/i', $hash)) {
            throw $this->unexpectedParamValue("hash", "hash", gettype($hash));
        }

        $this->hash = $hash;
        $this->nonce = $obj["none"] ?? null;
        $this->blockHash = $obj["blockHash"] ?? null;
        $this->blockNumber = $obj["blockNumber"] ?? null;
        $this->transactionIndex = $obj["transactionIndex"] ?? null;
        $this->value = $obj["value"] ?? null;
        $this->gasPrice = $obj["gasPrice"] ?? null;
        $this->gas = $obj["gas"] ?? null;

        // From and To
        $this->from = $obj["from"] ?? null;
        if (!is_string($this->from) || !preg_match('/^0x[a-f0-9]{40}$/i', $this->from)) {
            throw $this->unexpectedParamValue("from", "address");
        }

        $this->to = $obj["to"] ?? null;
        if (is_string($this->to)) {
            if (!preg_match('/^0x[a-f0-9]{40}$/i', $this->to)) {
                throw $this->unexpectedParamValue("to", "address");
            }
        }

        if (!is_string($this->to) && !is_null($this->to)) {
            throw $this->unexpectedParamValue("to", "null|address");
        }

        // Input
        $input = $obj["input"] ?? null;
        if (is_string($input)) {
            $this->input = $input;

            try {
                if (substr($this->input, 0, 10) === '0xa9059cbb') { // Token Transfer!
                    $this->_input = new TransactionInputTransfer($this->input);
                }
            } catch (ResponseObjectException $e) {
                trigger_error($e->getMessage(), E_USER_WARNING);
            }
        }
    }

    /**
     * @return TransactionInputInterface|null
     */
    public function input(): ?TransactionInputInterface
    {
        return $this->_input;
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
        $txId = is_int($this->hash) ? $this->hash : "???";
        return new ResponseObjectException(
            sprintf('Ethereum Block [%s]: %s', $txId, $message)
        );
    }
}
