<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/Tron.proto

namespace Protocol\NodeInfo;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>protocol.NodeInfo.MachineInfo</code>
 */
class MachineInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>int32 threadCount = 1;</code>
     */
    protected $threadCount = 0;
    /**
     * Generated from protobuf field <code>int32 deadLockThreadCount = 2;</code>
     */
    protected $deadLockThreadCount = 0;
    /**
     * Generated from protobuf field <code>int32 cpuCount = 3;</code>
     */
    protected $cpuCount = 0;
    /**
     * Generated from protobuf field <code>int64 totalMemory = 4;</code>
     */
    protected $totalMemory = 0;
    /**
     * Generated from protobuf field <code>int64 freeMemory = 5;</code>
     */
    protected $freeMemory = 0;
    /**
     * Generated from protobuf field <code>double cpuRate = 6;</code>
     */
    protected $cpuRate = 0.0;
    /**
     * Generated from protobuf field <code>string javaVersion = 7;</code>
     */
    protected $javaVersion = '';
    /**
     * Generated from protobuf field <code>string osName = 8;</code>
     */
    protected $osName = '';
    /**
     * Generated from protobuf field <code>int64 jvmTotalMemoery = 9;</code>
     */
    protected $jvmTotalMemoery = 0;
    /**
     * Generated from protobuf field <code>int64 jvmFreeMemory = 10;</code>
     */
    protected $jvmFreeMemory = 0;
    /**
     * Generated from protobuf field <code>double processCpuRate = 11;</code>
     */
    protected $processCpuRate = 0.0;
    /**
     * Generated from protobuf field <code>repeated .protocol.NodeInfo.MachineInfo.MemoryDescInfo memoryDescInfoList = 12;</code>
     */
    private $memoryDescInfoList;
    /**
     * Generated from protobuf field <code>repeated .protocol.NodeInfo.MachineInfo.DeadLockThreadInfo deadLockThreadInfoList = 13;</code>
     */
    private $deadLockThreadInfoList;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $threadCount
     *     @type int $deadLockThreadCount
     *     @type int $cpuCount
     *     @type int|string $totalMemory
     *     @type int|string $freeMemory
     *     @type float $cpuRate
     *     @type string $javaVersion
     *     @type string $osName
     *     @type int|string $jvmTotalMemoery
     *     @type int|string $jvmFreeMemory
     *     @type float $processCpuRate
     *     @type \Protocol\NodeInfo\MachineInfo\MemoryDescInfo[]|\Google\Protobuf\Internal\RepeatedField $memoryDescInfoList
     *     @type \Protocol\NodeInfo\MachineInfo\DeadLockThreadInfo[]|\Google\Protobuf\Internal\RepeatedField $deadLockThreadInfoList
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Core\Tron::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>int32 threadCount = 1;</code>
     * @return int
     */
    public function getThreadCount()
    {
        return $this->threadCount;
    }

    /**
     * Generated from protobuf field <code>int32 threadCount = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setThreadCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->threadCount = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 deadLockThreadCount = 2;</code>
     * @return int
     */
    public function getDeadLockThreadCount()
    {
        return $this->deadLockThreadCount;
    }

    /**
     * Generated from protobuf field <code>int32 deadLockThreadCount = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setDeadLockThreadCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->deadLockThreadCount = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 cpuCount = 3;</code>
     * @return int
     */
    public function getCpuCount()
    {
        return $this->cpuCount;
    }

    /**
     * Generated from protobuf field <code>int32 cpuCount = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setCpuCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->cpuCount = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int64 totalMemory = 4;</code>
     * @return int|string
     */
    public function getTotalMemory()
    {
        return $this->totalMemory;
    }

    /**
     * Generated from protobuf field <code>int64 totalMemory = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setTotalMemory($var)
    {
        GPBUtil::checkInt64($var);
        $this->totalMemory = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int64 freeMemory = 5;</code>
     * @return int|string
     */
    public function getFreeMemory()
    {
        return $this->freeMemory;
    }

    /**
     * Generated from protobuf field <code>int64 freeMemory = 5;</code>
     * @param int|string $var
     * @return $this
     */
    public function setFreeMemory($var)
    {
        GPBUtil::checkInt64($var);
        $this->freeMemory = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>double cpuRate = 6;</code>
     * @return float
     */
    public function getCpuRate()
    {
        return $this->cpuRate;
    }

    /**
     * Generated from protobuf field <code>double cpuRate = 6;</code>
     * @param float $var
     * @return $this
     */
    public function setCpuRate($var)
    {
        GPBUtil::checkDouble($var);
        $this->cpuRate = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string javaVersion = 7;</code>
     * @return string
     */
    public function getJavaVersion()
    {
        return $this->javaVersion;
    }

    /**
     * Generated from protobuf field <code>string javaVersion = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setJavaVersion($var)
    {
        GPBUtil::checkString($var, True);
        $this->javaVersion = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string osName = 8;</code>
     * @return string
     */
    public function getOsName()
    {
        return $this->osName;
    }

    /**
     * Generated from protobuf field <code>string osName = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setOsName($var)
    {
        GPBUtil::checkString($var, True);
        $this->osName = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int64 jvmTotalMemoery = 9;</code>
     * @return int|string
     */
    public function getJvmTotalMemoery()
    {
        return $this->jvmTotalMemoery;
    }

    /**
     * Generated from protobuf field <code>int64 jvmTotalMemoery = 9;</code>
     * @param int|string $var
     * @return $this
     */
    public function setJvmTotalMemoery($var)
    {
        GPBUtil::checkInt64($var);
        $this->jvmTotalMemoery = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int64 jvmFreeMemory = 10;</code>
     * @return int|string
     */
    public function getJvmFreeMemory()
    {
        return $this->jvmFreeMemory;
    }

    /**
     * Generated from protobuf field <code>int64 jvmFreeMemory = 10;</code>
     * @param int|string $var
     * @return $this
     */
    public function setJvmFreeMemory($var)
    {
        GPBUtil::checkInt64($var);
        $this->jvmFreeMemory = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>double processCpuRate = 11;</code>
     * @return float
     */
    public function getProcessCpuRate()
    {
        return $this->processCpuRate;
    }

    /**
     * Generated from protobuf field <code>double processCpuRate = 11;</code>
     * @param float $var
     * @return $this
     */
    public function setProcessCpuRate($var)
    {
        GPBUtil::checkDouble($var);
        $this->processCpuRate = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .protocol.NodeInfo.MachineInfo.MemoryDescInfo memoryDescInfoList = 12;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getMemoryDescInfoList()
    {
        return $this->memoryDescInfoList;
    }

    /**
     * Generated from protobuf field <code>repeated .protocol.NodeInfo.MachineInfo.MemoryDescInfo memoryDescInfoList = 12;</code>
     * @param \Protocol\NodeInfo\MachineInfo\MemoryDescInfo[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setMemoryDescInfoList($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Protocol\NodeInfo\MachineInfo\MemoryDescInfo::class);
        $this->memoryDescInfoList = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .protocol.NodeInfo.MachineInfo.DeadLockThreadInfo deadLockThreadInfoList = 13;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDeadLockThreadInfoList()
    {
        return $this->deadLockThreadInfoList;
    }

    /**
     * Generated from protobuf field <code>repeated .protocol.NodeInfo.MachineInfo.DeadLockThreadInfo deadLockThreadInfoList = 13;</code>
     * @param \Protocol\NodeInfo\MachineInfo\DeadLockThreadInfo[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setDeadLockThreadInfoList($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Protocol\NodeInfo\MachineInfo\DeadLockThreadInfo::class);
        $this->deadLockThreadInfoList = $arr;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(MachineInfo::class, \Protocol\NodeInfo_MachineInfo::class);

