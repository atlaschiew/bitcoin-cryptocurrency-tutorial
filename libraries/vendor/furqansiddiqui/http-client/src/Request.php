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
use HttpClient\Exception\RequestException;
use HttpClient\Exception\ResponseException;
use HttpClient\Response\HttpClientResponse;
use HttpClient\Response\JSONResponse;
use HttpClient\Response\Response;

/**
 * Class Request
 * @package HttpClient
 */
class Request
{
    /** @var null|int */
    private $httpVersion;
    /** @var string */
    private $method;
    /** @var string */
    private $url;
    /** @var array */
    private $headers;
    /** @var null|array */
    private $payload;
    /** @var null|string */
    private $payloadSendJSON;
    /** @var bool */
    private $json;
    /** @var bool */
    private $forceValidateJSON;
    /** @var null|SSL */
    private $ssl;
    /** @var null|Authentication */
    private $auth;
    /** @var null|string */
    private $userAgent;
    /** @var int|null */
    private $timeOut;
    /** @var int|null */
    private $connectTimeout;

    /**
     * Request constructor.
     * @param string $method
     * @param string $url
     * @throws HttpClientException
     */
    public function __construct(string $method, string $url)
    {
        // Check request method
        $method = strtoupper($method);
        if (!in_array($method, ["GET", "POST", "PUT", "DELETE"])) {
            throw new HttpClientException(
                sprintf('"%s" is not a valid or unsupported HTTP request method', $method)
            );
        }

        $this->method = $method;
        $this->headers = [];
        $this->json = false;
        $this->forceValidateJSON = true;
        $this->url($url);
    }

    /**
     * @param string $method
     * @param $arguments
     * @throws RequestException
     */
    public function __call(string $method, $arguments)
    {
        switch ($method) {
            case "obj_auth":
                $auth = $arguments[0] ?? null;
                if ($auth instanceof Authentication) {
                    $this->auth = $auth;
                }
                return;
            case "obj_ssl":
                $ssl = $arguments[0] ?? null;
                if ($ssl instanceof SSL) {
                    $this->ssl = $ssl;
                }
                return;
        }

        throw new RequestException('Cannot call inaccessible method');
    }

    /**
     * @param int|null $timeOut
     * @param int|null $connectTimeout
     * @return $this
     * @throws RequestException
     */
    public function setTimeout(?int $timeOut = null, ?int $connectTimeout = null): self
    {
        if ($timeOut > 0) {
            $this->timeOut = $timeOut;
        }

        if ($connectTimeout > 0) {
            $this->connectTimeout = $connectTimeout;
        }

        if ($connectTimeout > $timeOut) {
            throw new RequestException('connectTimeout value cannot exceed timeOut');
        }

        return $this;
    }

    /**
     * @param string $url
     * @return Request
     * @throws HttpClientException
     */
    public function url(string $url): self
    {
        if (!preg_match('/^(http|https):\/\/.*$/i', $url)) {
            throw new HttpClientException('Invalid URL');
        }

        $this->url = $url;
        return $this;
    }

    /**
     * @return SSL
     * @throws Exception\SSLException
     */
    public function ssl(): SSL
    {
        if (!$this->ssl) {
            $this->ssl = new SSL();
        }

        return $this->ssl;
    }

    /**
     * @return Authentication
     */
    public function authentication(): Authentication
    {
        if (!$this->auth) {
            $this->auth = new Authentication();
        }

        return $this->auth;
    }

    /**
     * @param array $data
     * @param bool|null $sendAsJSON
     * @return Request
     */
    public function payload(array $data, ?bool $sendAsJSON = null): self
    {
        if ($sendAsJSON) {
            $this->payloadSendJSON = true;
        }

        $this->payload = $data;
        return $this;
    }

    /**
     * @param int $flag
     * @return Request
     * @throws RequestException
     */
    public function useHttpVersion(int $flag): self
    {
        if (!in_array($flag, HttpClient::HTTP_VERSIONS)) {
            throw new RequestException('Invalid HTTP version to use');
        }

        $this->httpVersion = $flag;
        return $this;
    }

    /**
     * @param string $header
     * @param string $value
     * @return Request
     */
    public function header(string $header, string $value): self
    {
        $this->headers[] = sprintf('%s: %s', $header, $value);
        return $this;
    }

    /**
     * @param bool $json
     * @param bool $forceValidateResponse
     * @return Request
     */
    public function json(bool $json = true, bool $forceValidateResponse = true): self
    {
        $this->json = $json;
        $this->forceValidateJSON = $forceValidateResponse;
        return $this;
    }

    /**
     * @param string $userAgent
     * @return Request
     */
    public function userAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * @return HttpClientResponse
     * @throws HttpClientException
     * @throws RequestException
     * @throws ResponseException
     */
    public function send(): HttpClientResponse
    {
        //HttpClient::Test(); // Prerequisites check

        $ch = curl_init(); // Init cURL handler
        curl_setopt($ch, CURLOPT_URL, $this->url); // Set URL
        if ($this->httpVersion) {
            curl_setopt($ch, CURLOPT_HTTP_VERSION, $this->httpVersion);
        }

        // SSL?
        if (strtolower(substr($this->url, 0, 5)) === "https") {
            call_user_func([$this->ssl(), "register"], $ch); // Register SSL options
        }

        // Payload
        switch ($this->method) {
            case "GET":
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                if ($this->payload) {
                    // Override URL
                    $urlSep = parse_url($this->url, PHP_URL_QUERY) ? "&" : "?";
                    curl_setopt($ch, CURLOPT_URL, $this->url . $urlSep . http_build_query($this->payload));
                }

                break;
            default:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
                if ($this->payload) {
                    if ($this->json || $this->payloadSendJSON) {
                        $payload = json_encode($this->payload);
                        if (!$payload) {
                            throw new RequestException('Failed to JSON encode the payload');
                        }

                        $this->header('Content-type', 'application/json; charset=utf-8');
                        $this->header('Content-length', strval(strlen($payload)));
                    } else {
                        $payload = http_build_query($this->payload);
                    }

                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                }
                break;
        }

        // Headers
        if ($this->headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        }

        // Authentication
        if ($this->auth) {
            call_user_func([$this->auth, "register"], $ch);
        }

        // User agent
        if ($this->userAgent) {
            curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        }

        // Timeouts
        if ($this->timeOut) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeOut);
        }

        if ($this->connectTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        }

        // Finalise request
        $responseHeaders = [];
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function (
            /** @noinspection PhpUnusedParameterInspection */
            $ch, $header) use (&$responseHeaders) {
            $responseHeaders[] = $header;
            return strlen($header);
        });

        // Execute cURL request
        $response = curl_exec($ch);
        if ($response === false) {
            throw new RequestException(
                sprintf('cURL error [%d]: %s', curl_error($ch), curl_error($ch))
            );
        }

        // Response code
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        if (is_string($responseCode) && preg_match('/[0-9]+/', $responseCode)) {
            $responseCode = intval($responseCode); // In case HTTP response code is returned as string
        }

        if (!is_int($responseCode)) {
            throw new RequestException('Could not retrieve HTTP response code');
        }

        // Close cURL resource
        curl_close($ch);

        // Prepare response
        $jsonResponse = is_string($responseType) && preg_match('/json/', $responseType) ? true : $this->json;
        if ($jsonResponse) {
            try {
                if (!is_string($responseType)) {
                    throw new ResponseException('Invalid "Content-type" header received, expecting JSON', $responseCode);
                }

                if (strtolower(trim(explode(";", $responseType)[0])) !== "application/json") {
                    throw new ResponseException(
                        sprintf('Expected "application/json", got "%s"', $responseType),
                        $responseCode
                    );
                }

                return new JSONResponse($responseCode, $responseHeaders, $response); // Return
            } catch (ResponseException $e) {
                if ($this->forceValidateJSON) {
                    throw $e;
                }
            }
        }

        return new Response($responseCode, $responseHeaders, $response); // Return
    }
}