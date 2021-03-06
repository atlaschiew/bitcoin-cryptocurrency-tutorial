<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/contract/shield_contract.proto

namespace Protocol;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>protocol.IncrementalMerkleVoucher</code>
 */
class IncrementalMerkleVoucher extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.protocol.IncrementalMerkleTree tree = 1;</code>
     */
    protected $tree = null;
    /**
     * Generated from protobuf field <code>repeated .protocol.PedersenHash filled = 2;</code>
     */
    private $filled;
    /**
     * Generated from protobuf field <code>.protocol.IncrementalMerkleTree cursor = 3;</code>
     */
    protected $cursor = null;
    /**
     * Generated from protobuf field <code>int64 cursor_depth = 4;</code>
     */
    protected $cursor_depth = 0;
    /**
     * Generated from protobuf field <code>bytes rt = 5;</code>
     */
    protected $rt = '';
    /**
     * Generated from protobuf field <code>.protocol.OutputPoint output_point = 10;</code>
     */
    protected $output_point = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Protocol\IncrementalMerkleTree $tree
     *     @type \Protocol\PedersenHash[]|\Google\Protobuf\Internal\RepeatedField $filled
     *     @type \Protocol\IncrementalMerkleTree $cursor
     *     @type int|string $cursor_depth
     *     @type string $rt
     *     @type \Protocol\OutputPoint $output_point
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Core\Contract\ShieldContract::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.protocol.IncrementalMerkleTree tree = 1;</code>
     * @return \Protocol\IncrementalMerkleTree
     */
    public function getTree()
    {
        return isset($this->tree) ? $this->tree : null;
    }

    public function hasTree()
    {
        return isset($this->tree);
    }

    public function clearTree()
    {
        unset($this->tree);
    }

    /**
     * Generated from protobuf field <code>.protocol.IncrementalMerkleTree tree = 1;</code>
     * @param \Protocol\IncrementalMerkleTree $var
     * @return $this
     */
    public function setTree($var)
    {
        GPBUtil::checkMessage($var, \Protocol\IncrementalMerkleTree::class);
        $this->tree = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .protocol.PedersenHash filled = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getFilled()
    {
        return $this->filled;
    }

    /**
     * Generated from protobuf field <code>repeated .protocol.PedersenHash filled = 2;</code>
     * @param \Protocol\PedersenHash[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setFilled($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Protocol\PedersenHash::class);
        $this->filled = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.protocol.IncrementalMerkleTree cursor = 3;</code>
     * @return \Protocol\IncrementalMerkleTree
     */
    public function getCursor()
    {
        return isset($this->cursor) ? $this->cursor : null;
    }

    public function hasCursor()
    {
        return isset($this->cursor);
    }

    public function clearCursor()
    {
        unset($this->cursor);
    }

    /**
     * Generated from protobuf field <code>.protocol.IncrementalMerkleTree cursor = 3;</code>
     * @param \Protocol\IncrementalMerkleTree $var
     * @return $this
     */
    public function setCursor($var)
    {
        GPBUtil::checkMessage($var, \Protocol\IncrementalMerkleTree::class);
        $this->cursor = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int64 cursor_depth = 4;</code>
     * @return int|string
     */
    public function getCursorDepth()
    {
        return $this->cursor_depth;
    }

    /**
     * Generated from protobuf field <code>int64 cursor_depth = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setCursorDepth($var)
    {
        GPBUtil::checkInt64($var);
        $this->cursor_depth = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bytes rt = 5;</code>
     * @return string
     */
    public function getRt()
    {
        return $this->rt;
    }

    /**
     * Generated from protobuf field <code>bytes rt = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setRt($var)
    {
        GPBUtil::checkString($var, False);
        $this->rt = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.protocol.OutputPoint output_point = 10;</code>
     * @return \Protocol\OutputPoint
     */
    public function getOutputPoint()
    {
        return isset($this->output_point) ? $this->output_point : null;
    }

    public function hasOutputPoint()
    {
        return isset($this->output_point);
    }

    public function clearOutputPoint()
    {
        unset($this->output_point);
    }

    /**
     * Generated from protobuf field <code>.protocol.OutputPoint output_point = 10;</code>
     * @param \Protocol\OutputPoint $var
     * @return $this
     */
    public function setOutputPoint($var)
    {
        GPBUtil::checkMessage($var, \Protocol\OutputPoint::class);
        $this->output_point = $var;

        return $this;
    }

}

