<?php declare(strict_types=1);

namespace kornrunner\Signature;

use GMP;
use kornrunner\Serializer\HexSignatureSerializer;
use kornrunner\Signature\SignatureInterface;
use Mdanter\Ecc\Crypto\Signature\Signature as EccSignature;

class Signature extends EccSignature implements SignatureInterface
{
    protected $serializer;

    protected $recoveryParam;

    public function __construct(GMP $r, GMP $s, int $recoveryParam) {
        parent::__construct($r, $s);

        $this->serializer = new HexSignatureSerializer;
        $this->recoveryParam = $recoveryParam;
    }

    public function toHex(): string {
        return $this->serializer->serialize($this);
    }

    public function getRecoveryParam(): int {
        return $this->recoveryParam;
    }
}