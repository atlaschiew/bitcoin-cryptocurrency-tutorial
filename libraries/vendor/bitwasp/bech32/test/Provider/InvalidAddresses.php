<?php

namespace BitWasp\Test\Bech32\Provider;

class InvalidAddresses
{
    /**
     * @var array
     */
    private static $fixtures = [
        [
            "tb",
            "tc1qw508d6qejxtdg4y5r3zarvary0c5xw7kg3g4ty",
            "Invalid prefix for address"
        ],
        [
            "bc",
            "bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t5",
            "Invalid bech32 checksum"
        ],
        [
            "bc",
            "BC13W508D6QEJXTDG4Y5R3ZARVARY0C5XW7KN40WF2",
            "Invalid witness version"
        ],
        [
            "bc",
            "bc1rw5uspcuh",
            "Witness program size was out of valid range"
        ],
        [
            "bc",
            "bc10w508d6qejxtdg4y5r3zarvary0c5xw7kw508d6qejxtdg4y5r3zarvary0c5xw7kw5rljs90",
            "Invalid length for segwit address"
        ],
        [
            "bc",
            "BC1QR508D6QEJXTDG4Y5R3ZARVARYV98GJ9P",
            "Invalid size for V0 witness program"
        ],
        [
            "tb",
            "tb1qrp33g0q5c5txsp9arysrx4k6zdkfs4nce4xj0gdcccefvpysxf3q0sL5k7",
            "Data contains mixture of higher/lower case characters"
        ],
        [
            "bc",
            "bc1zw508d6qejxtdg4y5r3zarvaryvqyzf3du",
            "Invalid data"
        ],
        [
            "bc",
            "bc1gmk9yu",
            "Invalid length for segwit address"
        ],
    ];

    /**
     * @return array
     */
    public static function load()
    {
        return self::$fixtures;
    }
}
