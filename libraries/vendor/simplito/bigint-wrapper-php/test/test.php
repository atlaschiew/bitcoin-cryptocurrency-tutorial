<?php

use BI\BigInteger;

function test($a, $b, $message = "") {
    error_log(($a === $b ? "PASS" : "FAIL get: " . $a . ", expected: " . $b) . " " . $message);
}

function testB($a, $b, $message = "") {
    error_log(($a->toString() === $b ? "PASS" : "FAIL get: " . $a . ", expected: " . $b) . " " . $message);
}

function testSerialization($b, $msg = "") {
    test($b->toBits(), "1010000", $msg . " toBits");
    test($b->toBytes(), hex2bin("50"), $msg . " toBytes");
    test($b->toHex(), "50", $msg . " toHex");
    test($b->toDec(), "80", $msg . " toDec");
    test($b->toNumber(), 80, $msg . " toNumber");
    test($b->toBase(58), "1M", $msg . " to58");
}

function testCreate() {
    error_log("=============\nTest serialization\n=============");
    testSerialization(new BigInteger("1010000", 2), "bits");
    testSerialization(new BigInteger(hex2bin("50"), 256), "bytes");
    testSerialization(new BigInteger("50", 16), "hex");
    testSerialization(new BigInteger("80", 10), "dec");
    testSerialization(new BigInteger("80"), "dec2");
    testSerialization(new BigInteger(80), "number");
}

function testCreateSafeSingle($value, $base, $msg) {
    try {
        $z = new BigInteger($value, $base);
        error_log("FAIL exception during create " . $msg);
    }
    catch (\Exception $e) {
        error_log("PASS exception during create " . $msg);
    }
    test(BigInteger::createSafe($value, $base), false, "createSafe " . $msg);
}

function testCreateSafe() {
    error_log("=============\nTest create safe\n=============");
    testCreateSafeSingle("zz", 2, "bin");
    testCreateSafeSingle("zz", 10, "dec");
    testCreateSafeSingle("zz", 16, "hex");
}

function testSpaces() {
    error_log("=============\nTest spaces\n=============");
    test((new BigInteger("11  0   1", 2))->toBits(), "1101", "bin");
    test((new BigInteger("6   2 0  6", 10))->toDec(), "6206", "dec");
    test((new BigInteger("f3 5  12 ac 0", 16))->toHex(), "f3512ac0", "hex");
}

function testOp() {
    error_log("=============\nTest op\n=============");
    testB((new BigInteger(20))->add(34), "54", "add");
    testB((new BigInteger(20))->sub(14), "6", "sub");
    testB((new BigInteger(20))->mul(12), "240", "mul");
    testB((new BigInteger(20))->div(4), "5", "div");
    testB((new BigInteger(20))->divR(7), "6", "divR");
    $qr = (new BigInteger(20))->divQR(6);
    testB($qr[0], "3", "divQR[0]");
    testB($qr[1], "2", "divQR[1]");
    testB((new BigInteger(20))->mod(3), "2", "mod");
    testB((new BigInteger(54))->gcd(81), "27", "gcd");
    testB((new BigInteger(3))->modInverse(10), "7", "modInverse");
    testB((new BigInteger(3))->pow(4), "81", "pow");
    testB((new BigInteger(3))->powMod(4, 10), "1", "powMod");
    testB((new BigInteger(20))->abs(), "20", "abs");
    testB((new BigInteger(20))->neg(), "-20", "neg");
    testB((new BigInteger(20))->binaryAnd(18), "16", "binaryAnd");
    testB((new BigInteger(20))->binaryOr(18), "22", "binaryOr");
    testB((new BigInteger(20))->binaryXor(18), "6", "binaryXor");
    testB((new BigInteger(20))->setbit(3), "28", "setbit");
    test((new BigInteger(20))->testbit(4), true, "testbit true");
    test((new BigInteger(20))->testbit(3), false, "testbit false");
    test((new BigInteger(5))->testbit(0), true, "testbit 0 true");
    test((new BigInteger(6))->testbit(0), false, "testbit 0 false");
    test((new BigInteger(6))->testbit(1), true, "testbit 1 true");
    test((new BigInteger(5))->testbit(1), false, "testbit 1 false");
    test((new BigInteger(132))->testbit(7), true, "testbit 7 true");
    test((new BigInteger(81))->testbit(7), false, "testbit 7 false");
    test((new BigInteger(258))->testbit(8), true, "testbit 8 true");
    test((new BigInteger(253))->testbit(8), false, "testbit 8 false");
    test((new BigInteger(20))->scan0(2), 3, "scan0");
    test((new BigInteger(20))->scan1(3), 4, "scan1");
    test((new BigInteger(20))->cmp(22), -1, "cmp -1");
    test((new BigInteger(20))->cmp(20), 0, "cmp 0");
    test((new BigInteger(20))->cmp(18), 1, "cmp 1");
    test((new BigInteger(20))->equals(20), true, "equals true");
    test((new BigInteger(20))->equals(21), false, "equals false");
    test((new BigInteger(-20))->sign(), -1, "sign -1");
    test((new BigInteger(0))->sign(), 0, "sign 0");
    test((new BigInteger(20))->sign(), 1, "sign 1");
    testB(new BigInteger("-20"), "-20", "minus");
    testB(new BigInteger("-14", 16), "-20", "minus");
    testB(new BigInteger("-10100", 2), "-20", "minus");
}

function testBig() {
    error_log("=============\nTest big\n=============");
    $bits = "1001010111010010100001000101110110100001000101101000110101010101001";
    $hex = "eeaf0ab9adb38dd69c33f80afa8fc5e86072618775ff3c0b9ea2314c9c256576d674df7496ea81d3383b4813d692c6e0e0d5d8e250b98be48e495c1d6089dad15dc7d7b46154d6b6ce8ef4ad69b15d4982559b297bcf1885c529f566660e57ec68edbc3c05726cc02fd4cbf4976eaa9afd5138fe8376435b9fc61d2fc0eb06e3";
    $dec = "436529472098746319073192837123683467019263172846";
    $bytes = hex2bin($hex);
    test((new BigInteger($bits, 2))->toBits(), $bits, "init big from binary");
    test((new BigInteger($dec, 10))->toDec(), $dec, "init big from dec");
    test((new BigInteger($hex, 16))->toHex(), $hex, "init big from hex");
    test((new BigInteger($bytes, 256))->toBytes(), $bytes, "init big from buffer");
}

testCreate();
testCreateSafe();
testSpaces();
testOp();
testBig();