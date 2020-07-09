<?php

namespace BitWasp\Test\Unit\Bech32;

use BitWasp\Bech32\Exception\Bech32Exception;
use BitWasp\Test\Bech32\TestCase;

class DecodeTest extends TestCase
{
    public function failedDecodeFixtures()
    {
        return [
            ["\x201nwldj5", "Out of range character in bech32 string"],
            ["\x7f1axkwrx", "Out of range character in bech32 string"],
            ["\x801eym55h", "Out of range character in bech32 string"],
            ["an84characterslonghumanreadablepartthatcontainsthenumber1andtheexcludedcharactersbio1569pvx", "Bech32 string cannot exceed 90 characters in length"],
            ["10a06t8", "Bech32 string is too short"],
            ["1qzzfhee", "Empty HRP"],
            ["pzry9x0s0muk", "Missing separator character"],
            ["1pzry9x0s0muk", "Empty HRP"],
            ["x1b4n0q5v", "Invalid bech32 checksum"],
            ["de1lg7wt\xff", "Out of range character in bech32 string"],
            ["A1G7SGD8", "Invalid bech32 checksum"],
            ["li1dgmt3", "Too short checksum"],
            ["bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t5", "Invalid bech32 checksum"],
        ];
    }

    /**
     * @param string $bech32
     * @param string $exceptionMsg
     * @dataProvider failedDecodeFixtures
     */
    public function testDecodeFails($bech32, $exceptionMsg)
    {
        $this->expectException(Bech32Exception::class);
        $this->expectExceptionMessage($exceptionMsg);
        \BitWasp\Bech32\decode($bech32);
    }

    /**
     * @return array
     */
    public function validChecksumProvider()
    {
        return [
            ["A12UEL5L"],
            ["a12uel5l"],
            ["an83characterlonghumanreadablepartthatcontainsthenumber1andtheexcludedcharactersbio1tt5tgs"],
            ["abcdef1qpzry9x8gf2tvdw0s3jn54khce6mua7lmqqqxw"],
            ["11qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqc8247j"],
            ["split1checkupstagehandshakeupstreamerranterredcaperred2y9e3w"],
            ["?1ezyfcl"],
        ];
    }

    /**
     * https://github.com/sipa/bech32/blob/master/ref/python/tests.py#L90
     * @param string $hasValidChecksum
     * @dataProvider validChecksumProvider
     */
    public function testValidChecksum($hasValidChecksum)
    {
        \BitWasp\Bech32\decode($hasValidChecksum);

        $pos = strrpos($hasValidChecksum, "1");
        $invalidChecksum = substr($hasValidChecksum, 0, $pos+1) . chr(ord($hasValidChecksum[$pos+1])^1) . substr($hasValidChecksum, $pos+2);

        $this->expectException(Bech32Exception::class);
        \BitWasp\Bech32\decode($invalidChecksum);
    }

    /**
     * @return array
     */
    public function invalidChecksumProvider()
    {
        return [
            [" 1nwldj5"],
            ["\x7f"."1axkwrx"],
            ["an84characterslonghumanreadablepartthatcontainsthenumber1andtheexcludedcharactersbio1569pvx"],
            ["pzry9x0s0muk"],
            ["1pzry9x0s0muk"],
            ["x1b4n0q5v"],
            ["li1dgmt3"],
            ["de1lg7wt"."\xff"],
        ];
    }

    /**
     * https://github.com/sipa/bech32/blob/master/ref/python/tests.py#L100
     * @param string $hasValidChecksum
     * @dataProvider invalidChecksumProvider
     */
    public function testInvalidChecksum($hasValidChecksum)
    {
        $this->expectException(Bech32Exception::class);
        \BitWasp\Bech32\decode($hasValidChecksum);
    }
}
