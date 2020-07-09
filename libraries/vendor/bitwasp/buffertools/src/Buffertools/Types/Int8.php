<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

class Int8 extends AbstractSignedInt
{
    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::getBitSize()
     */
    public function getBitSize(): int
    {
        return 8;
    }
}
