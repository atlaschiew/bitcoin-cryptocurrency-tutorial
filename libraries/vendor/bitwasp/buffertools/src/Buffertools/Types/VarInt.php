<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\ByteOrder;
use BitWasp\Buffertools\Parser;

class VarInt extends AbstractType
{
    private $formatUint8 = "C";
    private $formatUint16LE = "v";
    private $formatUint32LE = "V";
    private $formatUint64LE = "P";

    /**
     * @param \GMP $integer
     * @return array
     * @deprecated
     */
    public function solveWriteSize(\GMP $integer)
    {
        if (gmp_cmp($integer, gmp_pow(gmp_init(2), 16)) < 0) {
            return [new Uint16(ByteOrder::LE), 0xfd];
        } else if (gmp_cmp($integer, gmp_pow(gmp_init(2), 32)) < 0) {
            return [new Uint32(ByteOrder::LE), 0xfe];
        } else if (gmp_cmp($integer, gmp_pow(gmp_init(2), 64)) < 0) {
            return [new Uint64(ByteOrder::LE), 0xff];
        } else {
            throw new \InvalidArgumentException('Integer too large, exceeds 64 bit');
        }
    }

    /**
     * @param \GMP $givenPrefix
     * @return UintInterface[]
     * @throws \InvalidArgumentException
     * @deprecated
     */
    public function solveReadSize(\GMP $givenPrefix)
    {
        if (gmp_cmp($givenPrefix, 0xfd) === 0) {
            return [new Uint16(ByteOrder::LE)];
        } else if (gmp_cmp($givenPrefix, 0xfe) === 0) {
            return [new Uint32(ByteOrder::LE)];
        } else if (gmp_cmp($givenPrefix, 0xff) === 0) {
            return [new Uint64(ByteOrder::LE)];
        }

        throw new \InvalidArgumentException('Unknown varint prefix');
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::read()
     */
    public function write($integer): string
    {
        if ($integer < 0xfd) {
            return pack($this->formatUint8, $integer);
        }

        $gmpInt = gmp_init($integer);
        if (gmp_cmp($gmpInt, gmp_sub(gmp_pow(2, 16), 1)) <= 0) {
            return pack("{$this->formatUint8}{$this->formatUint16LE}", 0xfd, $integer);
        } else if (gmp_cmp($gmpInt, gmp_sub(gmp_pow(2, 32), 1)) <= 0) {
            return pack("{$this->formatUint8}{$this->formatUint32LE}", 0xfe, $integer);
        } else if (gmp_cmp($gmpInt, gmp_sub(gmp_pow(2, 63), 1)) <= 0) {
            return pack("{$this->formatUint8}{$this->formatUint64LE}", 0xff, $integer);
        }

        throw new \RuntimeException("Unable to serialize varint, exceeds maximum value");
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::read()
     */
    public function read(Parser $parser)
    {
        $byte = unpack($this->formatUint8, $parser->readBytes(1)->getBinary())[1];
        if ($byte < 0xfd) {
            return $byte;
        } else if ($byte === 0xfd) {
            return unpack($this->formatUint16LE, $parser->readBytes(2)->getBinary())[1];
        } else if ($byte === 0xfe) {
            return unpack($this->formatUint32LE, $parser->readBytes(4)->getBinary())[1];
        } else {
            $uint64 = new Uint64(ByteOrder::LE);
            return $uint64->read($parser);
        }
    }
}
