<?php

require __DIR__ . "/../vendor/autoload.php";

use BitWasp\Buffertools\Buffer;

// Binary data and ASCII can be passed directly to a Buffer
$binary = new Buffer('hello world');
echo "Buffer 1: binary  : " . $binary->getBinary() . PHP_EOL;
echo "Buffer 1: hex     : " . $binary->getHex() . PHP_EOL;
echo PHP_EOL;

// Buffer::hex and Buffer::int convert data to binary
$hex = Buffer::hex('68656c6c6f20776f726c64');
echo "Buffer 2: binary  : " . $hex->getBinary() . PHP_EOL;
echo "Buffer 2: hex     : " . $hex->getHex() . PHP_EOL;
$first = $hex->slice(0, 1);
echo "Buffer 2: 1st char: " . $first->getHex() . PHP_EOL;
echo PHP_EOL;

// All Buffers expose getBinary(), getInt(), getHex()
$int = Buffer::int(65);
echo "Buffer 3: binary: " . $int->getBinary() . PHP_EOL;
echo "Buffer 3: int   : " . $int->getInt() . PHP_EOL;
echo "Buffer 3: hex   : " . $int->getHex() . PHP_EOL;
echo PHP_EOL;
