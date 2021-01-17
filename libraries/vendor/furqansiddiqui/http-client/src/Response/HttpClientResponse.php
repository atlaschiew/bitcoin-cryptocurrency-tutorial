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

namespace HttpClient\Response;

/**
 * Class HttpClientResponse
 * @package HttpClient\Response
 */
abstract class HttpClientResponse
{
    /** @var int */
    protected $code;
    /** @var array */
    protected $headers;

    /**
     * HttpClientResponse constructor.
     * @param int $code
     * @param array $headers
     * @param $body
     */
    final public function __construct(int $code, array $headers, ?string $body)
    {
        $this->code = $code;
        $this->handleHeaders($headers);
        $this->handleBody($body);
    }

    /**
     * @param $body
     * @return void
     */
    abstract protected function handleBody($body): void;

    /**
     * @return int
     */
    final public function code(): int
    {
        return $this->code;
    }

    /**
     * @param string $name
     * @return null|string
     */
    final public function header(string $name): ?string
    {
        return $this->headers[strtolower($name)] ?? null;
    }

    /**
     * @return array
     */
    final public function headers(): array
    {
        return $this->headers;
    }

    /**
     * @return null|string
     */
    final public function contentType(): ?string
    {
        return $this->header('Content-type');
    }

    /**
     * @param array $headers
     */
    private function handleHeaders(array $headers): void
    {
        foreach ($headers as $line) {
            if (preg_match('/^[\w\-]+\:/', $line)) {
                $header = preg_split('/:/', $line, 2);
                $name = trim(strval($header[0] ?? null));
                $value = trim(strval($header[1] ?? null));
                if ($name && $value) {
                    $this->headers[strtolower($name)] = $value;
                }
            }
        }
    }
}