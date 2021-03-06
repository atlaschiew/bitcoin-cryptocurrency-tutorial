<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/contract/shield_contract.proto

namespace Protocol;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>protocol.IncrementalMerkleVoucherInfo</code>
 */
class IncrementalMerkleVoucherInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated .protocol.IncrementalMerkleVoucher vouchers = 1;</code>
     */
    private $vouchers;
    /**
     * Generated from protobuf field <code>repeated bytes paths = 2;</code>
     */
    private $paths;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Protocol\IncrementalMerkleVoucher[]|\Google\Protobuf\Internal\RepeatedField $vouchers
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $paths
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Core\Contract\ShieldContract::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated .protocol.IncrementalMerkleVoucher vouchers = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getVouchers()
    {
        return $this->vouchers;
    }

    /**
     * Generated from protobuf field <code>repeated .protocol.IncrementalMerkleVoucher vouchers = 1;</code>
     * @param \Protocol\IncrementalMerkleVoucher[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setVouchers($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Protocol\IncrementalMerkleVoucher::class);
        $this->vouchers = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated bytes paths = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * Generated from protobuf field <code>repeated bytes paths = 2;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPaths($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::BYTES);
        $this->paths = $arr;

        return $this;
    }

}

