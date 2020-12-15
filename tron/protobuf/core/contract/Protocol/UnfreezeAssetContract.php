<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/contract/asset_issue_contract.proto

namespace Protocol;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>protocol.UnfreezeAssetContract</code>
 */
class UnfreezeAssetContract extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>bytes owner_address = 1;</code>
     */
    protected $owner_address = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $owner_address
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

}

