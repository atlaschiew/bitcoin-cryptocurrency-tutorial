<?php

namespace kornrunner;

use kornrunner\Ethereum\Transaction;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class TransactionTest extends TestCase {

    /**
     * @dataProvider input
     */
    public function testGetInput ($expect, $nonce, $gasPrice, $gasLimit, $to, $value, $data) {
        $transaction = new Transaction ($nonce, $gasPrice, $gasLimit, $to, $value, $data);
        $this->assertSame($expect, $transaction->getInput());
    }

    public static function input (): array {
        return [
            [
                ['nonce' => '', 'gasPrice' => '', 'gasLimit' => '', 'to' => '', 'value' => '', 'data' => '', 'v' => '', 'r' => '', 's' => ''],
                '', '', '', '', '', ''
            ],
            [
                ['nonce' => '04', 'gasPrice' => '03f5476a00', 'gasLimit' => '027f4b', 'to' => '1a8c8adfbe1c59e8b58cc0d515f07b7225f51c72', 'value' => '2a45907d1bef7c00', 'data' => '', 'v' => '', 'r' => '', 's' => ''],
                '04', '03f5476a00', '027f4b', '1a8c8adfbe1c59e8b58cc0d515f07b7225f51c72', '2a45907d1bef7c00', ''
            ],
        ];
    }

    /**
     * @dataProvider getRaw
     */
    public function testGetRaw ($expect, $privateKey, $chainId, $nonce, $gasPrice, $gasLimit, $to, $value, $data) {
        $transaction = new Transaction ($nonce, $gasPrice, $gasLimit, $to, $value, $data);
        $this->assertSame($expect, $transaction->getRaw($privateKey, $chainId));
    }

    public static function getRaw (): array {
        return [
            [
                'f86d048503f5476a0083027f4b941a8c8adfbe1c59e8b58cc0d515f07b7225f51c72882a45907d1bef7c00801ba0e68be766b40702e6d9c419f53d5e053c937eda36f0e973074d174027439e2b5da0790df3e4d0294f92d69104454cd96005e21095efd5f2970c2829736ca39195d8',
                'b2f2698dd7343fa5afc96626dee139cb92e58e5d04e855f4c712727bf198e898', 0, '04', '03f5476a00', '027f4b', '1a8c8adfbe1c59e8b58cc0d515f07b7225f51c72', '2a45907d1bef7c00', ''
            ],
            [
                'f86d048503f5476a0083027f4b941a8c8adfbe1c59e8b58cc0d515f07b7225f51c72882a45907d1bef7c008025a0db4efcc22a7d9b2cab180ce37f81959412594798cb9af7c419abb6323763cdd5a0631a0c47d27e5b6e3906a419de2d732e290b73ead4172d8598ce4799c13bda69',
                'b2f2698dd7343fa5afc96626dee139cb92e58e5d04e855f4c712727bf198e898', 1, '04', '03f5476a00', '027f4b', '1a8c8adfbe1c59e8b58cc0d515f07b7225f51c72', '2a45907d1bef7c00', ''
            ],
        ];
    }

    public function testBadPrivateKey () {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Incorrect private key');
        $transaction = new Transaction ();
        $transaction->getRaw('');
    }

}
