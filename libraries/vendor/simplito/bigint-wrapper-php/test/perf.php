<?php

define('S_MATH_BIGINTEGER_MODE', "bcmath");

require(__DIR__ . "/../lib/BigInteger.php");

use BI\BigInteger;

$a = new BigInteger("4547395333333333333333333333333333333333333343587493875493579375498759837593574935739857");
$b = new BigInteger("-4547395333333333333333333333333333333333333343587493875493579375498759837593574935739857");
$c = new BigInteger("0");
$hex = "eeaf0ab9adb38dd69c33f80afa8fc5e86072618775ff3c0b9ea2314c9c256576d674df7496ea81d3383b4813d692c6e0e0d5d8e250b98be48e495c1d6089dad15dc7d7b46154d6b6ce8ef4ad69b15d4982559b297bcf1885c529f566660e57ec68edbc3c05726cc02fd4cbf4976eaa9afd5138fe8376435b9fc61d2fc0eb06e3";
$bytes = hex2bin($hex);

function test($v, $b) {
    $start = microtime(true);
    $count = 10000;
    for ($i = 0; $i < $count; $i++) {
        $v->binaryAnd($b);
        //$v->toBytes();
        //BigInteger::getBC($v, 256);
    }
    $end = microtime(true);
    error_log($end - $start);
}

test($a, $a);
test($b, $b);
//test($bytes, $b);