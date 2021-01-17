<?php

namespace kornrunner;

use kornrunner\Serializer\HexPrivateKeySerializer;
use kornrunner\Signature\Signer;
use Mdanter\Ecc\Curves\CurveFactory;
use Mdanter\Ecc\Curves\SecgCurve;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Random\RandomGeneratorFactory;

class SignerTest extends TestCase
{

    public function testSign() {
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

        $this->assertEquals('f67118680df5993e8efca4d3ecc4172ca4ac5e3e007ea774293e373864809703', gmp_strval($signature->getR(), 16));
        $this->assertEquals('47427f3633371c1a30abbb2b717dbd78ef63d5b19b5a951f9d681cccdd520320', gmp_strval($signature->getS(), 16));
        $this->assertTrue(in_array($signature->getRecoveryParam(), [0, 1]));
        $this->assertTrue($signer->verify($key->getPublicKey(), $signature, $hash));

        $options['canonical'] = false;
        $signer = new Signer($adapter, $options);
        $signature = $signer->sign($key, $hash, $randomK);

        $this->assertEquals('f67118680df5993e8efca4d3ecc4172ca4ac5e3e007ea774293e373864809703', gmp_strval($signature->getR(), 16));
        $this->assertEquals('b8bd80c9ccc8e3e5cf5444d48e824285cb4b073513ee0b1c226a41bff2e43e21', gmp_strval($signature->getS(), 16));
        $this->assertTrue(in_array($signature->getRecoveryParam(), [0, 1]));
        $this->assertTrue($signer->verify($key->getPublicKey(), $signature, $hash));
    }

    public function testVerify() {
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

        $this->assertTrue($signer->verify($key->getPublicKey(), $signature, $hash));

        $options['canonical'] = false;
        $signer = new Signer($adapter, $options);
        $signature = $signer->sign($key, $hash, $randomK);

        $this->assertTrue($signer->verify($key->getPublicKey(), $signature, $hash));
    }
}