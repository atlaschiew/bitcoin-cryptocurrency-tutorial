<?php
/**
 * Created by PhpStorm.
 * User: tk
 * Date: 9/25/17
 * Time: 2:20 PM
 */

namespace BitWasp\Test\Bech32;

class Util
{
    public static function witnessProgram($version, $program)
    {
        if ($version < 0 || $version > 16) {
            throw new \RuntimeException("Invalid version for witness program");
        }

        $version = pack("C", ($version > 0 ? (0x50 + $version) : 0));
        $length = pack("C", strlen($program));

        return unpack("H*", "{$version}{$length}{$program}")[1];
    }
}
