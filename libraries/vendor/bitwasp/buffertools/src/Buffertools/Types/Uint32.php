<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\Parser;

class Uint32 extends AbstractUint
{
    private $formatBE = "N";
    private $formatLE = "V";

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::getBitSize()
     */
    public function getBitSize(): int
    {
        return 32;
    }

    /**
     * @param int|string $integer
     * @return string
     */
    public function write($integer): string
    {
        if ($this->isBigEndian()) {
            return pack($this->formatBE, $integer);
        }
        return pack($this->formatLE, $integer);
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::read()
     */
    public function read(Parser $parser)
    {
        $bytes = $parser->readBytes(4);
        if ($this->isBigEndian()) {
            return unpack($this->formatBE, $bytes->getBinary())[1];
        }
        return unpack($this->formatLE, $bytes->getBinary())[1];
    }
}
