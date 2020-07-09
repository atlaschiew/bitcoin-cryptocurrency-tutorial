<?php

declare(strict_types=1);

namespace BitWasp\Buffertools;

use BitWasp\Buffertools\Types\ByteString;
use BitWasp\Buffertools\Types\Int128;
use BitWasp\Buffertools\Types\Int16;
use BitWasp\Buffertools\Types\Int256;
use BitWasp\Buffertools\Types\Int32;
use BitWasp\Buffertools\Types\Int64;
use BitWasp\Buffertools\Types\Int8;
use BitWasp\Buffertools\Types\Uint8;
use BitWasp\Buffertools\Types\Uint16;
use BitWasp\Buffertools\Types\Uint32;
use BitWasp\Buffertools\Types\Uint64;
use BitWasp\Buffertools\Types\Uint128;
use BitWasp\Buffertools\Types\Uint256;
use BitWasp\Buffertools\Types\VarInt;
use BitWasp\Buffertools\Types\VarString;
use BitWasp\Buffertools\Types\Vector;

class TypeFactory implements TypeFactoryInterface
{
    /**
     * Add a Uint8 serializer to the template
     *
     * @return Uint8
     */
    public function uint8(): Uint8
    {
        return new Uint8(ByteOrder::BE);
    }

    /**
     * Add a little-endian Uint8 serializer to the template
     *
     * @return Uint8
     */
    public function uint8le(): Uint8
    {
        return new Uint8(ByteOrder::LE);
    }

    /**
     * Add a Uint16 serializer to the template
     *
     * @return Uint16
     */
    public function uint16(): Uint16
    {
        return new Uint16(ByteOrder::BE);
    }

    /**
     * Add a little-endian Uint16 serializer to the template
     *
     * @return Uint16
     */
    public function uint16le(): Uint16
    {
        return new Uint16(ByteOrder::LE);
    }

    /**
     * Add a Uint32 serializer to the template
     *
     * @return Uint32
     */
    public function uint32(): Uint32
    {
        return new Uint32(ByteOrder::BE);
    }

    /**
     * Add a little-endian Uint32 serializer to the template
     *
     * @return Uint32
     */
    public function uint32le(): Uint32
    {
        return new Uint32(ByteOrder::LE);
    }

    /**
     * Add a Uint64 serializer to the template
     *
     * @return Uint64
     */
    public function uint64(): Uint64
    {
        return new Uint64(ByteOrder::BE);
    }

    /**
     * Add a little-endian Uint64 serializer to the template
     *
     * @return Uint64
     */
    public function uint64le(): Uint64
    {
        return new Uint64(ByteOrder::LE);
    }

    /**
     * Add a Uint128 serializer to the template
     *
     * @return Uint128
     */
    public function uint128(): Uint128
    {
        return new Uint128(ByteOrder::BE);
    }

    /**
     * Add a little-endian Uint128 serializer to the template
     *
     * @return Uint128
     */
    public function uint128le(): Uint128
    {
        return new Uint128(ByteOrder::LE);
    }

    /**
     * Add a Uint256 serializer to the template
     *
     * @return Uint256
     */
    public function uint256(): Uint256
    {
        return new Uint256(ByteOrder::BE);
    }

    /**
     * Add a little-endian Uint256 serializer to the template
     *
     * @return Uint256
     */
    public function uint256le(): Uint256
    {
        return new Uint256(ByteOrder::LE);
    }

    /**
     * Add a int8 serializer to the template
     *
     * @return Int8
     */
    public function int8(): Int8
    {
        return new Int8(ByteOrder::BE);
    }

    /**
     * Add a little-endian Int8 serializer to the template
     *
     * @return Int8
     */
    public function int8le(): Int8
    {
        return new Int8(ByteOrder::LE);
    }

    /**
     * Add a int16 serializer to the template
     *
     * @return Int16
     */
    public function int16(): Int16
    {
        return new Int16(ByteOrder::BE);
    }

    /**
     * Add a little-endian Int16 serializer to the template
     *
     * @return Int16
     */
    public function int16le(): Int16
    {
        return new Int16(ByteOrder::LE);
    }

    /**
     * Add a int32 serializer to the template
     *
     * @return Int32
     */
    public function int32(): Int32
    {
        return new Int32(ByteOrder::BE);
    }

    /**
     * Add a little-endian Int serializer to the template
     *
     * @return Int32
     */
    public function int32le(): Int32
    {
        return new Int32(ByteOrder::LE);
    }

    /**
     * Add a int64 serializer to the template
     *
     * @return Int64
     */
    public function int64(): Int64
    {
        return new Int64(ByteOrder::BE);
    }

    /**
     * Add a little-endian Int64 serializer to the template
     *
     * @return Int64
     */
    public function int64le(): Int64
    {
        return new Int64(ByteOrder::LE);
    }

    /**
     * Add a int128 serializer to the template
     *
     * @return Int128
     */
    public function int128(): Int128
    {
        return new Int128(ByteOrder::BE);
    }

    /**
     * Add a little-endian Int128 serializer to the template
     *
     * @return Int128
     */
    public function int128le(): Int128
    {
        return new Int128(ByteOrder::LE);
    }

    /**
     * Add a int256 serializer to the template
     *
     * @return Int256
     */
    public function int256(): Int256
    {
        return new Int256(ByteOrder::BE);
    }

    /**
     * Add a little-endian Int256 serializer to the template
     *
     * @return Int256
     */
    public function int256le(): Int256
    {
        return new Int256(ByteOrder::LE);
    }

    /**
     * Add a VarInt serializer to the template
     *
     * @return VarInt
     */
    public function varint(): VarInt
    {
        return new VarInt();
    }

    /**
     * Add a VarString serializer to the template
     *
     * @return VarString
     */
    public function varstring(): VarString
    {
        return new VarString(new VarInt());
    }

    /**
     * Add a byte string serializer to the template. This serializer requires a length to
     * pad/truncate to.
     *
     * @param  int $length
     * @return ByteString
     */
    public function bytestring(int $length): ByteString
    {
        return new ByteString($length, ByteOrder::BE);
    }

    /**
     * Add a little-endian byte string serializer to the template. This serializer requires
     * a length to pad/truncate to.
     *
     * @param  int $length
     * @return ByteString
     */
    public function bytestringle(int $length): ByteString
    {
        return new ByteString($length, ByteOrder::LE);
    }

    /**
     * Add a vector serializer to the template. A $readHandler must be provided if the
     * template will be used to deserialize a vector, since it's contents are not known.
     *
     * The $readHandler should operate on the parser reference, reading the bytes for each
     * item in the collection.
     *
     * @param  callable $readHandler
     * @return Vector
     */
    public function vector(callable $readHandler): Vector
    {
        return new Vector($this->varint(), $readHandler);
    }
}
