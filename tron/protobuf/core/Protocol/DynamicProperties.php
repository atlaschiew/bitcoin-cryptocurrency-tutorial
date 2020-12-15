<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/Tron.proto

namespace Protocol;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * DynamicProperties
 *
 * Generated from protobuf message <code>protocol.DynamicProperties</code>
 */
class DynamicProperties extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>int64 last_solidity_block_num = 1;</code>
     */
    protected $last_solidity_block_num = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $last_solidity_block_num
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Core\Tron::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>int64 last_solidity_block_num = 1;</code>
     * @return int|string
     */
    public function getLastSolidityBlockNum()
    {
        return $this->last_solidity_block_num;
    }

    /**
     * Generated from protobuf field <code>int64 last_solidity_block_num = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setLastSolidityBlockNum($var)
    {
        GPBUtil::checkInt64($var);
        $this->last_solidity_block_num = $var;

        return $this;
    }

}

