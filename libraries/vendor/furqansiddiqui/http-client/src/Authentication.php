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

use HttpClient\Exception\AuthenticationException;
use HttpClient\Exception\HttpClientException;

/**
 * Class Authentication
 * @package HttpClient
 */
class Authentication
{
    public const BASIC = 3001;
    public const DIGEST = 3002;

    /** @var null|int */
    private $type;
    /** @var null|string */
    private $username;
    /** @var null|string */
    private $password;

    /**
     * Basic HTTP authentication
     *
     * @param string $username
     * @param string $password
     */
    public function basic(string $username, string $password)
    {
        $this->type = self::BASIC;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param $method
     * @param $args
     * @throws AuthenticationException
     * @throws HttpClientException
     */
    public function __call($method, $args)
    {
        switch ($method) {
            case "register":
                $this->register($args[0] ?? null);
                return;
        }

        throw new AuthenticationException(sprintf('Cannot call inaccessible method "%s"', $method));
    }

    /**
     * @param $ch
     * @throws AuthenticationException
     */
    private function register($ch)
    {
        if (!is_resource($ch)) {
            throw new AuthenticationException('Cannot register Authentication opts to a non-resource');
        }

        switch ($this->type) {
            case self::BASIC:
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, sprintf('%s:%s', $this->username, $this->password));
                break;
        }
    }
}