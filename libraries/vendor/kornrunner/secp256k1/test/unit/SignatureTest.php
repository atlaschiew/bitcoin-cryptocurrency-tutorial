<?php

namespace kornrunner;

use kornrunner\Serializer\HexPrivateKeySerializer;
use kornrunner\Signature\Signer;
use Mdanter\Ecc\Crypto\Signature\Signature;
use Mdanter\Ecc\Curves\CurveFactory;
use Mdanter\Ecc\Curves\SecgCurve;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Random\RandomGeneratorFactory;

class SignatureTest extends TestCase
{

    public function testToHex() {
        $adapter = EccFactory::getAdapter();
        $generator = CurveFactory::getGeneratorByName(SecgCurve::NAME_SECP_256K1);
        $deserializer = new HexPrivateKeySerializer($generator);
        $key = $deserializer->parse($this->testPrivateKey);
        $hash = gmp_init('98d22cdb65bbf8a392180cd2ee892b0a971c47e7d29daf31a3286d006b9db4dc', 16);
        $random = RandomGeneratorFactory::getHmacRandomGenerator($key, $hash, 'sha256');
        $n = $generator->getOrder();
        $randomK = $random->generate($n);

        $options = [
            'n' => $n,
            'canonical' => true
        ];
        $signer = new Signer($adapter, $options);
        $signature = $signer->sign($key, $hash, $randomK);

        $this->assertTrue($signature instanceof Signature);
        $this->assertEquals('f67118680df5993e8efca4d3ecc4172ca4ac5e3e007ea774293e37386480970347427f3633371c1a30abbb2b717dbd78ef63d5b19b5a951f9d681cccdd520320', $signature->toHex());
        $this->assertEquals(0, $signature->getRecoveryParam());
    }
}