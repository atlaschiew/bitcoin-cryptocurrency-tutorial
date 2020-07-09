<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

class Int16 extends AbstractSignedInt
{
    /**
     * @return int
     */
    public function getBitSize(): int
    {
        return 16;
    }
}
