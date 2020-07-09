<?php

declare(strict_types=1);

namespace BitWasp\Buffertools;

use Mdanter\Ecc\Math\GmpMathInterface;

class Buffer implements BufferInterface
{
    /**
     * @var int
     */
    protected $size;

    /**
     * @var string
     */
    protected $buffer;

    /**
     * @param string               $byteString
     * @param null|integer         $byteSize
     * @throws \Exception
     */
    public function __construct(string $byteString = '', int $byteSize = null)
    {
        if ($byteSize !== null) {
            // Check the integer doesn't overflow its supposed size
            if (strlen($byteString) > $byteSize) {
                throw new \Exception('Byte string exceeds maximum size');
            }
        } else {
            $byteSize = strlen($byteString);
        }

        $this->size   = $byteSize;
        $this->buffer = $byteString;
    }

    /**
     * Return a formatted version for var_dump
     */
    public function __debugInfo()
    {
        return [
            'size' => $this->size,
            'buffer' => '0x' . unpack("H*", $this->buffer)[1],
        ];
    }

    /**
     * Create a new buffer from a hex string
     *
     * @param string $hexString
     * @param int|null $byteSize
     * @return Buffer
     * @throws \Exception
     */
    public static function hex(string $hexString = '', int $byteSize = null): BufferInterface
    {
        if (strlen($hexString) > 0 && !ctype_xdigit($hexString)) {
            throw new \InvalidArgumentException('Buffer::hex: non-hex character passed');
        }

        $binary = pack("H*", $hexString);
        return new self($binary, $byteSize);
    }

    /**
     * @param int|string $integer
     * @param null|int $byteSize
     * @return Buffer
     */
    public static function int($integer, $byteSize = null): BufferInterface
    {
        $gmp = gmp_init($integer, 10);
        return self::gmp($gmp, $byteSize);
    }

    /**
     * @param \GMP $gmp
     * @return Buffer
     * @throws \Exception
     */
    public static function gmp(\GMP $gmp, $byteSize = null): BufferInterface
    {
        if (gmp_sign($gmp) < 0) {
            throw new \InvalidArgumentException('Negative integers not supported. This could be an application error, or you should be using templates.');
        }

        $hex = gmp_strval($gmp, 16);
        if ((mb_strlen($hex) % 2) !== 0) {
            $hex = "0{$hex}";
        }

        $binary = pack("H*", $hex);
        return new self($binary, $byteSize);
    }

    /**
     * @param int      $start
     * @param integer|null $end
     * @return BufferInterface
     * @throws \Exception
     */
    public function slice(int $start, int $end = null): BufferInterface
    {
        if ($start > $this->getSize()) {
            throw new \Exception('Start exceeds buffer length');
        }

        if ($end === null) {
            return new self(substr($this->getBinary(), $start));
        }

        if ($end > $this->getSize()) {
            throw new \Exception('Length exceeds buffer length');
        }

        $string = substr($this->getBinary(), $start, $end);
        if (!is_string($string)) {
            throw new \RuntimeException('Failed to slice string of with requested start/end');
        }

        $length = strlen($string);
        return new self($string, $length);
    }

    /**
     * Get the size of the buffer to be returned
     *
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Get the size of the value stored in the buffer
     *
     * @return int
     */
    public function getInternalSize(): int
    {
        return strlen($this->buffer);
    }

    /**
     * @return string
     */
    public function getBinary(): string
    {
        // if a size is specified we'll make sure the value returned is that size
        if ($this->size !== null) {
            if (strlen($this->buffer) < $this->size) {
                return str_pad($this->buffer, $this->size, chr(0), STR_PAD_LEFT);
            } elseif (strlen($this->buffer) > $this->size) {
                return substr($this->buffer, 0, $this->size);
            }
        }

        return $this->buffer;
    }

    /**
     * @return string
     */
    public function getHex(): string
    {
        return unpack("H*", $this->getBinary())[1];
    }

    /**
     * @return \GMP
     */
    public function getGmp(): \GMP
    {
        $gmp = gmp_init($this->getHex(), 16);
        return $gmp;
    }

    /**
     * @return int|string
     */
    public function getInt()
    {
        return gmp_strval($this->getGmp(), 10);
    }

    /**
     * @return Buffer
     */
    public function flip(): BufferInterface
    {
        /** @var Buffer $buffer */
        $buffer = Buffertools::flipBytes($this);
        return $buffer;
    }

    /**
     * @param BufferInterface $other
     * @return bool
     */
    public function equals(BufferInterface $other): bool
    {
        return ($other->getSize() === $this->getSize()
             && $other->getBinary() === $this->getBinary());
    }
}
