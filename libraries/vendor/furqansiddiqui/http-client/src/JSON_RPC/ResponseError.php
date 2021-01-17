<?php
declare(strict_types=1);

namespace HttpClient\JSON_RPC;

use HttpClient\Exception\JSON_RPC_ResponseException;

/**
 * Class ResponseError
 * @package HttpClient\JSON_RPC
 */
class ResponseError
{
    /** @var int */
    public $code;
    /** @var string|null */
    public $message;
    /** @var mixed|null */
    public $data;

    /**
     * ResponseError constructor.
     * @param array $error
     * @throws JSON_RPC_ResponseException
     */
    public function __construct(array $error)
    {
        $code = $error["code"] ?? null;
        if (!is_int($code)) {
            throw new JSON_RPC_ResponseException('RPC response error code must be integer');
        }

        $message = $error["message"] ?? null;
        if (!is_string($message) && !is_null($message)) {
            throw new JSON_RPC_ResponseException(
                sprintf('Invalid data type "%s" for RPC error prop. "message"', gettype($message))
            );
        }


        $this->code = $code;
        $this->message = $message;

        // Data
        $data = $error["data"] ?? null;
        if ($data) {
            if (!is_scalar($data) && !is_array($data)) {
                throw new JSON_RPC_ResponseException(
                    sprintf('Invalid data type "%s" for RPC error prop. "data"', gettype($data))
                );
            }
        }

        $this->data = $data;
    }
}