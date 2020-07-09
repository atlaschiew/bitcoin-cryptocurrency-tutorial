<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

interface SignedIntInterface extends TypeInterface
{
    /**
     * @return int
     */
    public function getBitSize(): int;
}
