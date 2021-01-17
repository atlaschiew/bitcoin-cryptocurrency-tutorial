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

/**
 * Class TransactionReceipt
 * @package EthereumRPC\Response
 */
class TransactionReceipt
{
    /** @var string */
    public $transactionHash;
    /** @var int */
    public $transactionIndex;
    /** @var string */
    public $blockHash;
    /** @var int */
    public $blockNumber;
    /** @var int */
    public $cumulativeGasUsed;
    /** @var int */
    public $gasUsed;
    /** @var null|string */
    public $contractAddress;
    /** @var array */
    public $logs;
    /** @var string */
    public $logsBloom;
    /** @var null|string */
    public $root;
    /** @var null|string */
    public $status;

    /**
     * TransactionReceipt constructor.
     * @param array $obj
     */
    public function __construct(array $obj)
    {
        $this->transactionHash = strval($obj["transactionHash"] ?? "");
        $this->transactionIndex = strval($obj["transactionIndex"] ?? 0);
        $this->blockHash = strval($obj["blockHash"] ?? "");
        $this->blockNumber = strval($obj["blockNumber"] ?? 0);
        $this->cumulativeGasUsed = strval($obj["cumulativeGasUsed"] ?? 0);
        $this->gasUsed = strval($obj["gasUsed"] ?? 0);
        $this->contractAddress = isset($obj["contractAddress"]) ? strval($obj["contractAddress"]) : null;
        $this->logs = isset($obj["logs"]) && is_array($obj["logs"]) ? $obj["logs"] : null;
        $this->root = isset($obj["root"]) ? strval($obj["root"]) : null;
        $this->status = isset($obj["status"]) ? strval($obj["status"]) : null;
    }
}
