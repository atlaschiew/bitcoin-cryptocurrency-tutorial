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
use EthereumRPC\Exception\GethException;
use EthereumRPC\Validator;

/**
 * Class Contract
 *
 * Ideally this class should be extended instead of using directly, therefore no magic methods are coded,
 * see our ERC20 token implementation for an example (https://github.com/furqansiddiqui/erc20-php)
 *
 * @package EthereumRPC\Contracts
 */
class Contract
{
    /** @var EthereumRPC */
    private $client;
    /** @var ABI */
    private $abi;
    /** @var string */
    private $address;

    /**
     * Contract constructor.
     * @param EthereumRPC $client
     * @param ABI $abi
     * @param string $addr
     * @throws ContractsException
     */
    public function __construct(EthereumRPC $client, ABI $abi, string $addr)
    {
        if (!Validator::Address($addr)) {
            throw new ContractsException('Invalid contract Ethereum address');
        }

        $this->client = $client;
        $this->abi = $abi;
        $this->address = $addr;
    }

    /**
     * @return ABI
     */
    public function abi(): ABI
    {
        return $this->abi;
    }

    /**
     * @param string $func
     * @param array|null $args
     * @param bool $rawOutput
     * @param string $block
     * @return array|mixed|null
     * @throws GethException
     * @throws \EthereumRPC\Exception\ConnectionException
     * @throws \EthereumRPC\Exception\ContractABIException
     * @throws \Exception
     * @throws \HttpClient\Exception\HttpClientException
     */
    public function call(string $func, ?array $args = null, bool $rawOutput = false, string $block = "latest")
    {
        $data = $this->abi->encodeCall($func, $args);
        $params = [
            "to" => $this->address,
            "data" => $data
        ];

        $request = $this->client->jsonRPC("eth_call", null, [$params, $block]);
        $res = $request->get("result");
        if (!is_string($res)) {
            throw GethException::unexpectedResultType("eth_call", "string", gettype($res));
        }

        if ($rawOutput) { // Raw output? return response as-is?
            return $res;
        }

        return $this->abi->decodeResponse($func, $res);
    }
}
