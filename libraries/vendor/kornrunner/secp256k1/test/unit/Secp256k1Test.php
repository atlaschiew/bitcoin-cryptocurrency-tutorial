<?php

namespace kornrunner;

use kornrunner\Secp256k1;

class Secp256k1Test extends TestCase
{
    protected $secp256k1;

    public function setUp() {
        parent::setUp();
        $this->secp256k1 = new Secp256k1();
    }

    /**
     * @dataProvider sign
     */
    public function testSign(string $message, string $key, array $expected) {
        $signature = $this->secp256k1->sign($message, $key);

        $this->assertEquals($expected['r'], gmp_strval($signature->getR(), 16));
        $this->assertEquals($expected['s'], gmp_strval($signature->getS(), 16));
        $this->assertEquals($expected['v'], $signature->getRecoveryParam());
    }

    public static function sign(): array {
        return [
            ['98d22cdb65bbf8a392180cd2ee892b0a971c47e7d29daf31a3286d006b9db4dc', 'd0459987fdde1f41e524fddbf4b646cd9d3bea7fd7d63feead3f5dfce6174a3d', [
                'v' => 0,
                'r' => 'f67118680df5993e8efca4d3ecc4172ca4ac5e3e007ea774293e373864809703',
                's' => '47427f3633371c1a30abbb2b717dbd78ef63d5b19b5a951f9d681cccdd520320']],
            ['710aee292b0f1749aaa0cfef67111e2f716afbdb475e7f250bdb80c6655b0a66', 'd0459987fdde1f41e524fddbf4b646cd9d3bea7fd7d63feead3f5dfce6174a3d', [
                'v' => 0,
                'r' => '8d8bfd01c48454b5b3fed2361cbd0e8c3282d5bd2e26762e4c9dfbe1ef35f325',
                's' => '6d6a5dc397934b5544835f34ff24263cbc00bdd516b6f0df3f29cdf6c779ccfb']],
            ['58a2db04c169254495a55b6dd5609a4902678ec29eac46df1e95994cdbeaebbb', '554ae3b2efb87c276274456ff53af73756c6edf3f3e5a2412bbbd7f1142f5626', [
                'v' => 1,
                'r' => '7754ba071e98e79f55b6c12db974b2c4ba565257827cf8cac0426cbf2d76ec12',
                's' => '4bbc98ba84f2b53536c0ac8686eea9bfeb2cc768b54b3a6dd9e8166e2b892cb1']],
            ['58a2db04c169254495a55b6dd5609a4902678ec29eac46df1e95994cdbeaebbb', '9c812de98b3005d373468f6f946f638a00da6dd8de481d3c5b3eb438b5374aa8', [
                'v' => 0,
                'r' => '6ed38b6d40fc5a7d218570427e448be3d9ca10e64c84a5fb0c14055381322e57',
                's' => '13c8ac49fdacd728c55a9e093856d5f46418d6d3ccda4ad91348b5e6bd4d446d']],
            ['dd6bc704c297d6e39a30a694403f6e3b04233dc2a1d44434848f7df1c704b7e4', '554ae3b2efb87c276274456ff53af73756c6edf3f3e5a2412bbbd7f1142f5626', [
                'v' => 0,
                'r' => '188e7cfa0fb73430b6a2819ec0898764e68c9a79722d8afa98b571c6feb8a67f',
                's' => '524ac3a2ba8d046092c54b99b3150c486a0a32a4e2874fa071bc17e10ac4eecb']],
            ['dd6bc704c297d6e39a30a694403f6e3b04233dc2a1d44434848f7df1c704b7e4', '9c812de98b3005d373468f6f946f638a00da6dd8de481d3c5b3eb438b5374aa8', [
                'v' => 0,
                'r' => 'b3c549fcb91a304bb264d35309fb48e53a84b2119428c0324331a44919973301',
                's' => '3f009717694941a4a756e97411ae1366f2eb274bd28ba52d572e42d26f8af258']],
        ];
    }

    /**
     * @dataProvider verify
     */
    public function testVerify(string $message, string $key, string $publicKey) {
        $signature = $this->secp256k1->sign($message, $key);
        $this->assertTrue($this->secp256k1->verify($message, $signature, $publicKey));
    }

    public static function verify (): array {
        return [
            ['98d22cdb65bbf8a392180cd2ee892b0a971c47e7d29daf31a3286d006b9db4dc', 'd0459987fdde1f41e524fddbf4b646cd9d3bea7fd7d63feead3f5dfce6174a3d', '04cf60398ae73fd947ffe120fba68947ec741fe696438d68a2e52caca139613ff94f220cd0d3e886f95aa226f2ad2b86be1dd5cda2813fd505d1f6a8f552904864'],
            ['710aee292b0f1749aaa0cfef67111e2f716afbdb475e7f250bdb80c6655b0a66', 'd0459987fdde1f41e524fddbf4b646cd9d3bea7fd7d63feead3f5dfce6174a3d', '04cf60398ae73fd947ffe120fba68947ec741fe696438d68a2e52caca139613ff94f220cd0d3e886f95aa226f2ad2b86be1dd5cda2813fd505d1f6a8f552904864'],
        ];
    }

}