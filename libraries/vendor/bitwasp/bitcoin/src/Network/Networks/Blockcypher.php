<?php
/*
refer
https://www.blockcypher.com/dev/bitcoin/#testing
*/

namespace BitWasp\Bitcoin\Network\Networks;

use BitWasp\Bitcoin\Network\Network;
use BitWasp\Bitcoin\Script\ScriptType;

class Blockcypher extends Network
{
    /**
     * {@inheritdoc}
     * @see Network::$base58PrefixMap
     */
    public $base58PrefixMap = [
        self::BASE58_ADDRESS_P2PKH => "1b",/*changed*/
        self::BASE58_ADDRESS_P2SH => "1f",/*changed*/
        self::BASE58_WIF => "49",
    ];

    /**
     * {@inheritdoc}
     * @see Network::$bech32PrefixMap
     */
    protected $bech32PrefixMap = [
        self::BECH32_PREFIX_SEGWIT => "bc",
    ];

    /**
     * {@inheritdoc}
     * @see Network::$bip32PrefixMap
     */
    protected $bip32PrefixMap = [
        self::BIP32_PREFIX_XPUB => "0488b21e",
        self::BIP32_PREFIX_XPRV => "0488ade4",
    ];

    /**
     * {@inheritdoc}
     * @see Network::$bip32ScriptTypeMap
     */
    protected $bip32ScriptTypeMap = [
        self::BIP32_PREFIX_XPUB => ScriptType::P2PKH,
        self::BIP32_PREFIX_XPRV => ScriptType::P2PKH,
    ];

    /**
     * {@inheritdoc}
     * @see Network::$signedMessagePrefix
     */
    protected $signedMessagePrefix = "Bitcoin Signed Message";

    /**
     * {@inheritdoc}
     * @see Network::$p2pMagic
     */
    protected $p2pMagic = "d9b4bef9";
}
