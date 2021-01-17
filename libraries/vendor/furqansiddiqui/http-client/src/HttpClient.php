<?php
/**
 * This file is a part of "furqansiddiqui/http-client" package.
 * https://github.com/furqansiddiqui/http-client
 *
 * Copyright (c) 2019 Furqan A. Siddiqui <hello@furqansiddiqui.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or visit following link:
 * https://github.com/furqansiddiqui/http-client/blob/master/LICENSE.md
 */

declare(strict_types=1);

namespace HttpClient;

use HttpClient\Exception\HttpClientException;

/**
 * Class HttpClient
 */
class HttpClient
{
    public const VERSION = "0.4.5";
    public const REQUEST_METHODS = ["GET", "POST", "PUT", "DELETE"];

    // HTTP version
    public const HTTP_VERSION_1 = CURL_HTTP_VERSION_1_0;
    public const HTTP_VERSION_1_1 = CURL_HTTP_VERSION_1_1;
    public const HTTP_VERSION_2 = CURL_HTTP_VERSION_2_0;

    public const HTTP_VERSIONS = [
        self::HTTP_VERSION_1,
        self::HTTP_VERSION_1_1,
        self::HTTP_VERSION_2
    ];

    /**
     * @param string $url
     * @return Request
     * @throws HttpClientException
     */
    public static function Get(string $url): Request
    {
        return new Request('GET', $url);
    }

    /**
     * @param string $url
     * @return Request
     * @throws HttpClientException
     */
    public static function Post(string $url): Request
    {
        return new Request('POST', $url);
    }

    /**
     * @param string $url
     * @return Request
     * @throws HttpClientException
     */
    public static function Put(string $url): Request
    {
        return new Request('PUT', $url);
    }

    /**
     * @param string $url
     * @return Request
     * @throws HttpClientException
     */
    public static function Delete(string $url): Request
    {
        return new Request('DELETE', $url);
    }

    /**
     * @param string $host
     * @param int $port
     * @return json_RPC
     * @throws Exception\JSON_RPC_Exception
     */
    public static function JSON_RPC_V1(string $host, int $port): json_RPC
    {
        return (new JSON_RPC("1.0"))
            ->server($host, $port);
    }

    /**
     * @param string $host
     * @param int $port
     * @return json_RPC
     * @throws Exception\JSON_RPC_Exception
     */
    public static function JSON_RPC_V2(string $host, int $port): json_RPC
    {
        return (new JSON_RPC("2.0"))
            ->server($host, $port);
    }

    /**
     * Prerequisites Check
     * @return bool
     * @throws HttpClientException
     */
    public static function Test(): bool
    {
        // Curl
        if (!extension_loaded("curl")) {
            throw new HttpClientException('Required extension "curl" is unavailable');
        }

        // Json
        if (!function_exists("json_encode")) {
            throw new HttpClientException('Required extension "json" is unavailable');
        }

        return true;
    }
}