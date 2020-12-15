<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/Tron.proto

namespace Protocol;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>protocol.Transactions</code>
 */
class Transactions extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated .protocol.Transaction transactions = 1;</code>
     */
    private $transactions;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Protocol\Transaction[]|\Google\Protobuf\Internal\RepeatedField $transactions
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Core\Tron::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated .protocol.Transaction transactions = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Generated from protobuf field <code>repeated .protocol.Transaction transactions = 1;</code>
     * @param \Protocol\Transaction[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setTransactions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Protocol\Transaction::class);
        $this->transactions = $arr;

        return $this;
    }

}

