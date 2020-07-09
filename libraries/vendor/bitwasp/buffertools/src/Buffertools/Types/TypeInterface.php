<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\Parser;

interface TypeInterface
{
    /**
     * Flip whatever bitstring is given to us
     *
     * @param  string $bitString
     * @return string
     */
    public function flipBits(string $bitString): string;

    /**
     * @param mixed $integer
     * @return string
     */
    public function write($integer): string;

    /**
     * @param Parser $parser
     * @return mixed
     */
    public function read(Parser $parser);

    /**
     * @return int
     */
    public function getByteOrder(): int;
}
