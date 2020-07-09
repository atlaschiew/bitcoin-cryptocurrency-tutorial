<?php

declare(strict_types=1);

namespace BitWasp\Buffertools;

interface SerializableInterface
{
    /**
     * @return Buffer
     */
    public function getBuffer();
}
