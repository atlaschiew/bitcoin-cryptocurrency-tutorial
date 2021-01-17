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

namespace EthereumRPC\Contracts\ABI;

use EthereumRPC\Exception\ContractABIException;

/**
 * Class Method
 * @package EthereumRPC\Contracts\ABI
 */
class Method
{
    /** @var string|null */
    public $type;
    /** @var string|null */
    public $name;
    /** @var null|array */
    public $inputs;
    /** @var null|array */
    public $outputs;
    /** @var null|bool */
    public $constant;
    /** @var bool */
    public $payable;

    /**
     * Method constructor.
     * @param array $method
     * @throws ContractABIException
     */
    public function __construct(array $method)
    {
        // Type
        $this->type = $method["type"] ?? null;
        if (!is_string($this->type) || !in_array($this->type, ["function", "constructor", "fallback"])) {
            throw new ContractABIException(sprintf('Cannot create method for type "%s"', strval($this->type)));
        }

        // Name
        $this->name = $method["name"] ?? null;
        if (!is_string($this->name) && !is_null($this->name)) { // Loosened for "constructor" and "fallback"
            throw new ContractABIException('Unexpected value for param "name"');
        }

        if ($this->type === "function") {
            if (!is_string($this->name) || !preg_match('/^\w+$/', $this->name)) {
                throw new ContractABIException('ABI method type "function" requires a valid name');
            }
        }

        // Constant
        $this->constant = $method["constant"] ?? null;
        if (!is_bool($this->constant) && !is_null($this->constant)) {
            throw $this->unexpectedParamValue("constant", "bool", gettype($this->constant));
        }

        // Payable
        $this->payable = $method["payable"] ?? null;
        if (!is_bool($this->payable) && !is_null($this->payable)) {
            throw $this->unexpectedParamValue("constant", "bool", gettype($this->payable));
        }

        // Inputs
        $inputs = $method["inputs"] ?? false;
        if (!is_array($inputs)) { // Must be an Array
            if ($this->type !== "fallback") { // ...unless its type "fallback"
                throw $this->unexpectedParamValue("inputs", "array");
            }
        }

        $this->inputs = [];
        if (is_array($inputs)) {
			
            $this->inputs = $this->params("inputs", $inputs);
        }

        // Outputs
        $this->outputs = null;
        $outputs = $method["outputs"] ?? false;
        if (is_array($outputs)) {
            $this->outputs = $this->params("outputs", $outputs);
        }
    }

    /**
     * @param string $which
     * @param array $params
     * @return array
     * @throws ContractABIException
     */
    private function params(string $which, array $params): array
    {
        $methodId = $this->name ?? $this->type;
        $result = [];

        $index = 0;
        foreach ($params as $param) {
            if (!is_array($param)) {
                throw new ContractABIException(
                    sprintf(
                        'All "%s" params for method "%s" must be type Array, got "%s" at index %d',
                        $which,
                        $methodId,
                        gettype($param),
                        $index
                    )
                );
            }

            $name = $param["name"] ?? null;
            if (!is_string($name) || !preg_match('/^\w*$/', $name)) {
                throw new ContractABIException(
                    sprintf('Bad value for param "name" of "%s" at index %d', $which, $index)
                );
            }

            $type = $param["type"] ?? null;
            if (!is_string($type) || !preg_match('/^\w+$/', $type)) {
                throw new ContractABIException(
                    sprintf('Bad value for param "type" of "%s" at index %d', $which, $index)
                );
            }

            if (!preg_match('/^((hash|uint|int|string){1}(8|16|32|64|128|256)?|bool|address|bytes)$/', $type)) {
                throw new ContractABIException(
                    sprintf('Invalid/unacceptable type for param "%s" in "%s"', $name, $which)
                );
            }

            $methodParam = new MethodParam();
            $methodParam->name = $name;
            $methodParam->type = $type;
            $result[] = $methodParam;
            $index++;
        }

        return $result;
    }

    /**
     * @param string $param
     * @param null|string $expected
     * @param null|string $got
     * @return ContractABIException
     */
    private function unexpectedParamValue(string $param, ?string $expected = null, ?string $got = null): ContractABIException
    {
        $message = sprintf('Bad/unexpected value for param "%s"', $param);
        if ($expected) {
            $message .= sprintf(', expected "%s"', $expected);
        }

        if ($got) {
            $message .= sprintf(', got "%s"', $got);
        }


        return $this->exception($message);
    }

    /**
     * @param string $message
     * @return ContractABIException
     */
    private function exception(string $message): ContractABIException
    {
        $methodName = is_string($this->name) ? $this->name : "*unnamed*";
        return new ContractABIException(
            sprintf('ABI method [%s]: %s', $methodName, $message)
        );
    }
}
