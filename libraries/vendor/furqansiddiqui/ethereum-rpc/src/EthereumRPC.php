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

use EthereumRPC\API\Eth;
use EthereumRPC\API\Personal;
use EthereumRPC\Contracts\Constructor;
use EthereumRPC\Exception\ConnectionException;
use EthereumRPC\Exception\GethException;
use HttpClient\Exception\ResponseException;
use HttpClient\Request;
use HttpClient\Response\JSONResponse;

/**
 * Class EthereumRPC
 * @package EthereumRPC
 */
class EthereumRPC
{
    public const VERSION = "1.16.1";
    public const SCALE = 8;

    /** @var string */
    private $host;

    /** @var int */
    private $port;

    /** @var bool */
    private $ssl;

    /** @var Eth */
    private $eth;
    
    /** @var Personal */
    private $personal;

    /**
     * EthereumRPC constructor.
     * @param string $host
     * @param int|null $port
     */
    public function __construct(string $host, ?int $port = null)
    {
        $this->host = $host;
        $this->port = $port;
        $this->ssl = false;
        $this->eth = new Eth($this);
        $this->personal = new Personal($this);
    }

    /**
     * @return Eth
     */
    public function eth(): Eth
    {
        return $this->eth;
    }

    /**
     * @return Personal
     */
    public function personal(): Personal
    {
        return $this->personal;
    }

    /**
     * @return Constructor
     */
    public function contract(): Constructor
    {
        return new Constructor($this);
    }

    /**
     * @param null|string $endPoint
     * @return string
     */
    private function url(?string $endPoint = null): string
    {
        $protocol = $this->ssl ? "https" : "http";

        if ($this->port) {
            return sprintf('%s://%s:%s%s', $protocol, $this->host, $this->port, $endPoint);
        }

        return sprintf('%s://%s%s', $protocol, $this->host, $endPoint);
    }

    /**
     * @param Request $request
     * @return Request
     */
    private function prepare(Request $request): Request
    {
        return $request;
    }

    /**
     * @param string $command
     * @param null|string $endpoint
     * @param array|null $params
     * @param null|string $method
     * @return JSONResponse
     * @throws ConnectionException
     * @throws GethException
     * @throws \HttpClient\Exception\HttpClientException
     */
    public function jsonRPC(string $command, ?string $endpoint = null, ?array $params = null, ?string $method = 'POST'): JSONResponse
    {
        // Prepare JSON RPC Call
        $id = sprintf('%s_%d', $command, time());
        $request = new Request($method, $this->url($endpoint));
        $request->json(); // JSON request

        // Payload
        $request->payload([
            "jsonrpc" => "2.0",
            "id" => $id,
            "method" => $command,
            "params" => $params ?? []
        ]);

        // Send JSON RPC Request to Bitcoin daemon
        try {
            $this->prepare($request);
            $response = $request->send();
        } catch (\Exception $e) {
            if ($e instanceof ResponseException && $e->getCode()) {
                switch ($e->getCode()) {
                    case 401:
                        throw new ConnectionException('401 Unauthorized');
                }
            }

            throw new ConnectionException($e->getMessage(), $e->getCode());
        }

        // Is a JSONResponse?
        if (!$response instanceof JSONResponse) {
            throw new ConnectionException(sprintf('Expected a JSONResponse, got "%s"', get_class($response)));
        }

        // Cross-check response ID with request ID
        if ($response->get("id") !== $id) {
            throw new GethException('Response does not belong to sent request');
        }

        // Check for Error
        $error = $response->get("error");
        if (is_array($error)) {
            $errorCode = intval($error["code"] ?? 0);
            $errorMessage = $error["message"] ?? 'An error occurred';
            throw new GethException($errorMessage, $errorCode);
        }

        // Result
        if (!$response->has("result")) {
            throw new GethException('No response was received');
        }

        return $response;
    }
}
