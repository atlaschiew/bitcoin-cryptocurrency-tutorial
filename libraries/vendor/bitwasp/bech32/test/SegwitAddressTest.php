<?php

namespace BitWasp\Test\Bech32;

use function BitWasp\Bech32\decodeSegwit;
use function BitWasp\Bech32\encodeSegwit;
use BitWasp\Bech32\Exception\Bech32Exception;
use BitWasp\Test\Bech32\Provider\InvalidAddresses;
use BitWasp\Test\Bech32\Provider\ValidAddresses;

class SegwitAddressTest extends TestCase
{
    /**
     * @return array
     */
    public function validAddressProvider()
    {
        return ValidAddresses::load();
    }

    /**
     * https://github.com/sipa/bech32/blob/master/ref/python/tests.py#L106
     * @param string $hrp
     * @param string $bech32
     * @param string $hexScript
     * @dataProvider validAddressProvider
     */
    public function testValidAddress($hrp, $bech32, $hexScript)
    {
        list ($version, $program) = decodeSegwit($hrp, $bech32);
        $this->assertEquals($hexScript, Util::witnessProgram($version, $program));

        $addr = encodeSegwit($hrp, $version, $program);
        $this->assertEquals(strtolower($bech32), strtolower($addr));
    }


    public function invalidAddressProvider()
    {
        return [
            ["tc1qw508d6qejxtdg4y5r3zarvary0c5xw7kg3g4ty"],
            ["bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t5"],
            ["BC13W508D6QEJXTDG4Y5R3ZARVARY0C5XW7KN40WF2"],
            ["bc1rw5uspcuh"],
            ["bc10w508d6qejxtdg4y5r3zarvary0c5xw7kw508d6qejxtdg4y5r3zarvary0c5xw7kw5rljs90"],
            ["BC1QR508D6QEJXTDG4Y5R3ZARVARYV98GJ9P"],
            ["tb1qrp33g0q5c5txsp9arysrx4k6zdkfs4nce4xj0gdcccefvpysxf3q0sL5k7"],
            ["tb1pw508d6qejxtdg4y5r3zarqfsj6c3"],
            ["tb1qrp33g0q5c5txsp9arysrx4k6zdkfs4nce4xj0gdcccefvpysxf3pjxtptv"],
        ];
    }

    /**
     * @param string $bech32
     * @dataProvider invalidAddressProvider
     */
    public function testInvalidAddress($bech32)
    {
        try {
            decodeSegwit("bc", $bech32);
            $threw = false;
        } catch (\Exception $e) {
            $threw = true;
        }

        $this->assertTrue($threw, "expected mainnet hrp to fail");

        try {
            decodeSegwit("tb", $bech32);
            $threw = false;
        } catch (\Exception $e) {
            $threw = true;
        }

        $this->assertTrue($threw, "expected testnet hrp to fail");
    }

    /**
     * @return array
     */
    public function invalidAddressProvider2()
    {
        return InvalidAddresses::load();
    }

    /**
     * @param $prefix
     * @param $bech32
     * @param $exceptionMsg
     * @dataProvider invalidAddressProvider2
     */
    public function testInvalidAddressReasons($prefix, $bech32, $exceptionMsg)
    {
        $this->expectException(Bech32Exception::class);
        $this->expectExceptionMessage($exceptionMsg);

        decodeSegwit($prefix, $bech32);
    }
}
