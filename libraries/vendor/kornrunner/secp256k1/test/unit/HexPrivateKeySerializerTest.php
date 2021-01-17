<?php

namespace kornrunner;

use kornrunner\Serializer\HexPrivateKeySerializer;
use Mdanter\Ecc\Curves\CurveFactory;
use Mdanter\Ecc\Curves\SecgCurve;

class HexPrivateKeySerializerTest extends TestCase
{
    protected $serializer;

    public function setUp()
    {
        parent::setUp();
        $generator = CurveFactory::getGeneratorByName(SecgCurve::NAME_SECP_256K1);

        $this->serializer = new HexPrivateKeySerializer($generator);
    }

    /**
     * @dataProvider parse
     */
    public function testParse(string $privateKey) {
        $key = $this->serializer->parse($privateKey);
        $this->assertEquals(gmp_init($privateKey, 16), $key->getSecret());
    }

    public static function parse(): array {
        return [
            ['d0459987fdde1f41e524fddbf4b646cd9d3bea7fd7d63feead3f5dfce6174a3d'],
            ['0xd0459987fdde1f41e524fddbf4b646cd9d3bea7fd7d63feead3f5dfce6174a3d'],
        ];
    }

    /**
     * @dataProvider serialize
     */
    public function testSerialize(string $privateKey, string $expect) {
        $key = $this->serializer->serialize($this->serializer->parse($privateKey));
        $this->assertEquals($expect, $key);
    }

    public static function serialize(): array {
        return [
            ['d0459987fdde1f41e524fddbf4b646cd9d3bea7fd7d63feead3f5dfce6174a3d', 'd0459987fdde1f41e524fddbf4b646cd9d3bea7fd7d63feead3f5dfce6174a3d'],
            ['0xd0459987fdde1f41e524fddbf4b646cd9d3bea7fd7d63feead3f5dfce6174a3d', 'd0459987fdde1f41e524fddbf4b646cd9d3bea7fd7d63feead3f5dfce6174a3d'],
        ];
    }
}