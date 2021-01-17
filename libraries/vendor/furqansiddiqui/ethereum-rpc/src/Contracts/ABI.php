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

use EthereumRPC\Contracts\ABI\DataTypes;
use EthereumRPC\Contracts\ABI\Method;
use EthereumRPC\Contracts\ABI\MethodParam;
use EthereumRPC\Contracts\ABI\SHA3\Keccak;
use EthereumRPC\Exception\ContractABIException;

/**
 * Class ABI
 * https://github.com/ethereum/wiki/wiki/Ethereum-Contract-ABI
 * @package EthereumRPC\Contracts
 */
class ABI
{
    /** @var null|Method */
    private $constructor;
    /** @var null|Method */
    private $fallback;
    /** @var array */
    private $functions;
    /** @var array */
    private $events;

    /** @var bool */
    private $strictMode;

    /**
     * ABI constructor.
     * @param array $abi
     */
    public function __construct(array $abi)
    {
        $this->strictMode = true;
        $this->functions = [];
        $this->events = [];

        $index = 0;
        foreach ($abi as $block) {
			
			
            try {
                if (!is_array($block)) {
                    throw new ContractABIException(
                        sprintf('Unexpected data type "%s" at ABI array index %d, expecting Array', gettype($block), $index)
                    );
                }

                $type = $block["type"] ?? null;
				
				
                switch ($type) {
                    case "constructor":
                    case "function":
                    case "fallback":
				
					
                        $method = new Method($block);
						
                        switch ($method->type) {
                            case "constructor":
                                $this->constructor = $method;
                                break;
                            case "function":
                                $this->functions[$method->name] = $method;
                                break;
                            case "fallback":
                                $this->fallback = $method;
                                break;
                        }
                        break;
                    case "event":
                        // Todo: parse events
                        break;
                    default:
                        throw new ContractABIException(
                            sprintf('Bad/Unexpected value for ABI block param "type" at index %d', $index)
                        );
                }
            } catch (ContractABIException $e) {
                // Trigger an error instead of throwing exception if a block within ABI fails,
                // to make sure rest of ABI blocks will work
				//echo sprintf('[%s] %s', get_class($e), $e->getMessage());
                trigger_error(sprintf('[%s] %s', get_class($e), $e->getMessage()));
            }

            $index++;
        }
    }

    /**
     * @param string $name
     * @param array|null $args
     * @return string
     * @throws ContractABIException
     * @throws \Exception
     */
    public function encodeCall(string $name, ?array $args): string
    {
        $method = $this->functions[$name] ?? null;
        if (!$method instanceof Method) {
            throw new ContractABIException(sprintf('Calling method "%s" is undefined in ABI', $name));
        }

        $givenArgs = $args;
        $givenArgsCount = is_array($givenArgs) ? count($givenArgs) : 0;
        $methodParams = $method->inputs;
        $methodParamsCount = is_array($methodParams) ? count($methodParams) : 0;

        // Strict mode
        if ($this->strictMode) {
            // Params/args count must match
            if ($methodParamsCount || $givenArgsCount) {
                if ($methodParamsCount !== $givenArgsCount) {
                    throw new ContractABIException(
                        sprintf('Method "%s" requires %d args, given %d', $name, $methodParamsCount, $givenArgsCount)
                    );
                }
            }
        }

        $encoded = "";
        $methodParamsTypes = [];
        for ($i = 0; $i < $methodParamsCount; $i++) {
            /** @var MethodParam $param */
            $param = $methodParams[$i];
            $arg = $givenArgs[$i];
			
            $encoded .= DataTypes::Encode($param->type, $arg);
            $methodParamsTypes[] = $param->type;
        }

        $encodedMethodCall = Keccak::hash(sprintf('%s(%s)', $method->name, implode(",", $methodParamsTypes)), 256);
		
        return '0x' . substr($encodedMethodCall, 0, 8) . $encoded;
    }

    /**
     * @param string $name
     * @param string $encoded
     * @return array
     * @throws ContractABIException
     */
    public function decodeResponse(string $name, string $encoded): array
    {
        $method = $this->functions[$name] ?? null;
        if (!$method instanceof Method) {
            throw new ContractABIException(sprintf('Calling method "%s" is undefined in ABI', $name));
        }

        // Remove suffix "0x"
        if (substr($encoded, 0, 2) === '0x') {
            $encoded = substr($encoded, 2);
        }


        // Output params
        $methodResponseParams = $method->outputs ?? [];
        $methodResponseParamsCount = count($methodResponseParams);

        // What to expect
        if ($methodResponseParamsCount <= 0) {
            return [];
        } elseif ($methodResponseParamsCount === 1) {
            // Put all in a single chunk
            $chunks = [$encoded];
        } else {
            // Split in chunks of 64 bytes
            $chunks = str_split($encoded, 64);
        }


        $result = []; // Prepare
        for ($i = 0; $i < $methodResponseParamsCount; $i++) {
            /** @var MethodParam $param */
            $param = $methodResponseParams[$i];
            $chunk = $chunks[$i];
            $decoded = DataTypes::Decode($param->type, $chunk);

            if ($param->name) {
                $result[$param->name] = $decoded;
            } else {
                $result[] = $decoded;
            }
        }

        return $result;
    }
}
