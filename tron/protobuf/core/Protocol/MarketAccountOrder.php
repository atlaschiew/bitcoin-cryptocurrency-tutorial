<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/Tron.proto

namespace Protocol;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>protocol.MarketAccountOrder</code>
 */
class MarketAccountOrder extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>bytes owner_address = 1;</code>
     */
    protected $owner_address = '';
    /**
     * order_id list
     *
     * Generated from protobuf field <code>repeated bytes orders = 2;</code>
     */
    private $orders;
    /**
     * active count
     *
     * Generated from protobuf field <code>int64 count = 3;</code>
     */
    protected $count = 0;
    /**
     * Generated from protobuf field <code>int64 total_count = 4;</code>
     */
    protected $total_count = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $owner_address
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $orders
     *           order_id list
     *     @type int|string $count
     *           active count
     *     @type int|string $total_count
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Core\Tron::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>bytes owner_address = 1;</code>
     * @return string
     */
    public function getOwnerAddress()
    {
        return $this->owner_address;
    }

    /**
     * Generated from protobuf field <code>bytes owner_address = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setOwnerAddress($var)
    {
        GPBUtil::checkString($var, False);
        $this->owner_address = $var;

        return $this;
    }

    /**
     * order_id list
     *
     * Generated from protobuf field <code>repeated bytes orders = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * order_id list
     *
     * Generated from protobuf field <code>repeated bytes orders = 2;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setOrders($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::BYTES);
        $this->orders = $arr;

        return $this;
    }

    /**
     * active count
     *
     * Generated from protobuf field <code>int64 count = 3;</code>
     * @return int|string
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * active count
     *
     * Generated from protobuf field <code>int64 count = 3;</code>
     * @param int|string $var
     * @return $this
     */
    public function setCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->count = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int64 total_count = 4;</code>
     * @return int|string
     */
    public function getTotalCount()
    {
        return $this->total_count;
    }

    /**
     * Generated from protobuf field <code>int64 total_count = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setTotalCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->total_count = $var;

        return $this;
    }

}

