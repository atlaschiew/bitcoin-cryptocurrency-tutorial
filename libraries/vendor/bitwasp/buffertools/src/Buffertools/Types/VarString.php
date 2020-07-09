<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;
use BitWasp\Buffertools\Exceptions\ParserOutOfRange;
use BitWasp\Buffertools\Parser;

class VarString extends AbstractType
{
    /**
     * @var VarInt
     */
    private $varint;

    /**
     * @param VarInt $varInt
     */
    public function __construct(VarInt $varInt)
    {
        $this->varint = $varInt;
        parent::__construct($varInt->getByteOrder());
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::write()
     */
    public function write($buffer): string
    {
        if (!$buffer instanceof BufferInterface) {
            throw new \InvalidArgumentException('Must provide a buffer');
        }

        $binary = $this->varint->write($buffer->getSize()) . $buffer->getBinary();
        return $binary;
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::write()
     * @param Parser $parser
     * @return \BitWasp\Buffertools\BufferInterface
     * @throws \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     * @throws \Exception
     */
    public function read(Parser $parser): BufferInterface
    {
        $length = $this->varint->read($parser);

        if ($length > $parser->getSize() - $parser->getPosition()) {
            throw new ParserOutOfRange("Insufficient data remaining for VarString");
        }

        if (gmp_cmp(gmp_init($length, 10), gmp_init(0, 10)) == 0) {
            return new Buffer();
        }

        return $parser->readBytes((int) $length);
    }
}
