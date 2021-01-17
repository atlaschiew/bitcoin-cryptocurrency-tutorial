<?php

namespace kornrunner;

use InvalidArgumentException;

class HexSignatureSerializerTest extends TestCase
{

    /**
     * @dataProvider data
     */
    public function testParse(string $input, string $expect) {
        $sig = $this->sigSerializer->parse($input);
        $this->assertEquals($expect, gmp_strval($sig->getR(), 16) . gmp_strval($sig->getS(), 16));
    }

    public function testParseException() {
        $this->expectException(InvalidArgumentException::class);
        $this->sigSerializer->parse($this->signed . random_bytes(3));
    }

    /**
     * @dataProvider data
     */
    public function testSerialize(string $input, string $expect) {
        $parsed = $this->sigSerializer->parse($input);
        $signed = $this->sigSerializer->serialize($parsed);
        $this->assertEquals($expect, $signed);
    }

    public static function data(): array {
        return [
            ['f67118680df5993e8efca4d3ecc4172ca4ac5e3e007ea774293e37386480970347427f3633371c1a30abbb2b717dbd78ef63d5b19b5a951f9d681cccdd520320', 'f67118680df5993e8efca4d3ecc4172ca4ac5e3e007ea774293e37386480970347427f3633371c1a30abbb2b717dbd78ef63d5b19b5a951f9d681cccdd520320'],
            ['0xf67118680df5993e8efca4d3ecc4172ca4ac5e3e007ea774293e37386480970347427f3633371c1a30abbb2b717dbd78ef63d5b19b5a951f9d681cccdd520320', 'f67118680df5993e8efca4d3ecc4172ca4ac5e3e007ea774293e37386480970347427f3633371c1a30abbb2b717dbd78ef63d5b19b5a951f9d681cccdd520320'],
        ];
    }

}