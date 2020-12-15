<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/contract/asset_issue_contract.proto

namespace Protocol;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>protocol.ParticipateAssetIssueContract</code>
 */
class ParticipateAssetIssueContract extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>bytes owner_address = 1;</code>
     */
    protected $owner_address = '';
    /**
     * Generated from protobuf field <code>bytes to_address = 2;</code>
     */
    protected $to_address = '';
    /**
     * this field is token name before the proposal ALLOW_SAME_TOKEN_NAME is active, otherwise it is token id and token is should be in string format.
     *
     * Generated from protobuf field <code>bytes asset_name = 3;</code>
     */
    protected $asset_name = '';
    /**
     * the amount of drops
     *
     * Generated from protobuf field <code>int64 amount = 4;</code>
     */
    protected $amount = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $owner_address
     *     @type string $to_address
     *     @type string $asset_name
     *           this field is token name before the proposal ALLOW_SAME_TOKEN_NAME is active, otherwise it is token id and token is should be in string format.
     *     @type int|string $amount
     *           the amount of drops
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Core\Contract\AssetIssueContract::initOnce();
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
     * Generated from protobuf field <code>bytes to_address = 2;</code>
     * @return string
     */
    public function getToAddress()
    {
        return $this->to_address;
    }

    /**
     * Generated from protobuf field <code>bytes to_address = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setToAddress($var)
    {
        GPBUtil::checkString($var, False);
        $this->to_address = $var;

        return $this;
    }

    /**
     * this field is token name before the proposal ALLOW_SAME_TOKEN_NAME is active, otherwise it is token id and token is should be in string format.
     *
     * Generated from protobuf field <code>bytes asset_name = 3;</code>
     * @return string
     */
    public function getAssetName()
    {
        return $this->asset_name;
    }

    /**
     * this field is token name before the proposal ALLOW_SAME_TOKEN_NAME is active, otherwise it is token id and token is should be in string format.
     *
     * Generated from protobuf field <code>bytes asset_name = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setAssetName($var)
    {
        GPBUtil::checkString($var, False);
        $this->asset_name = $var;

        return $this;
    }

    /**
     * the amount of drops
     *
     * Generated from protobuf field <code>int64 amount = 4;</code>
     * @return int|string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * the amount of drops
     *
     * Generated from protobuf field <code>int64 amount = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setAmount($var)
    {
        GPBUtil::checkInt64($var);
        $this->amount = $var;

        return $this;
    }

}

