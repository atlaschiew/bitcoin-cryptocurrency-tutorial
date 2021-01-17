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

namespace HttpClient\JSON_RPC;

use HttpClient\Exception\JSON_RPC_ResponseException;
use HttpClient\JSON_RPC;
use HttpClient\Response\JSONResponse;

/**
 * Class Response
 * @package HttpClient\JSON_RPC
 */
class Response
{
    /** @var JSONResponse */
    private $_response;

    /** @var null|string */
    public $jsonrpc;
    /** @var string */
    public $id;
    /** @var null|mixed */
    public $result;
    /** @var null|ResponseError */
    public $error;

    /**
     * Response constructor.
     * @param JSON_RPC $client
     * @param JSONResponse $response
     * @param null $id
     * @throws JSON_RPC_ResponseException
     */
    public function __construct(JSON_RPC $client, JSONResponse $response, $id = null)
    {
        $this->_response = $response;

        // Version
        $this->jsonrpc = $response->get("jsonrpc");
        if ($client->specification === "2.0" && $this->jsonrpc !== "2.0") {
            throw new JSON_RPC_ResponseException(
                'Response param "jsonrpc" must be "2.0", received "%s"', $this->jsonrpc
            );
        }

        // ID
        $this->id = $response->get("id");
        if ($id && $id !== $this->id) {
            throw new JSON_RPC_ResponseException('JSON RPC response ID does not match');
        }

        // Error
        $error = $response->get("error");
        if (is_array($error) && $error) {
            $this->error = new ResponseError($error);
        }

        // Result
        if (!$this->error) {
            $this->result = $response->get("result");
            /*if (!$this->result) {
                throw new JSON_RPC_ResponseException('JSON RPC required prop "result" not found');
            }*/

            if (!is_scalar($this->result) && !is_array($this->result) && !is_null($this->result)) {
                throw new JSON_RPC_ResponseException(
                    sprintf('Invalid data type "%s" for "result", ', gettype($this->result))
                );
            }
        }
    }

    /**
     * @return JSONResponse
     */
    public function http(): JSONResponse
    {
        return $this->_response;
    }
}