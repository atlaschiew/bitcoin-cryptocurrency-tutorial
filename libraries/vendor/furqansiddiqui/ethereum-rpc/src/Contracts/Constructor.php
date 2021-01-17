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

namespace EthereumRPC\Contracts;

use EthereumRPC\EthereumRPC;
use EthereumRPC\Exception\ContractsException;

/**
 * Class Constructor
 * @package EthereumRPC\Contracts
 */
class Constructor
{
    /** @var EthereumRPC */
    private $client;
    /** @var null|ABI */
    private $abi;

    /**
     * Constructor constructor.
     * @param EthereumRPC $client
     */
    public function __construct(EthereumRPC $client)
    {
        $this->client = $client;
    }

    /**
     * @param ABI $abi
     * @return Constructor
     */
    public function use(ABI $abi): self
    {
        $this->abi = $abi;
        return $this;
    }

    /**
     * @return ABI
     * @throws ContractsException
     */
    public function abi(): ABI
    {
        if (!$this->abi) {
            throw new ContractsException('Contract ABI is not defined');
        }

        return $this->abi;
    }

    /**
     * @param string $abiPath
     * @return Constructor
     * @throws ContractsException
     */
    public function load(string $abiPath): self
    {
        $fileBasename = basename($abiPath);
        if (!file_exists($abiPath)) {
            throw new ContractsException(sprintf('ABI json file "%s" not found', $fileBasename));
        }

        $source = @file_get_contents($abiPath);
        if (!$source) {
            throw new ContractsException(sprintf('Failed to read ABI file "%s"', $fileBasename));
        }

        $decoded = json_decode($source, true);
        if (!is_array($decoded)) {
            throw new ContractsException(sprintf('Failed to JSON decode ABI file "%s"', $fileBasename));
        }

        $this->abi = new ABI($decoded);
        return $this;
    }

    /**
     * @param string $addr
     * @return Contract
     * @throws \EthereumRPC\Exception\ContractsException
     */
    public function address(string $addr): Contract
    {
        return new Contract($this->client, $this->abi(), $addr);
    }
}
