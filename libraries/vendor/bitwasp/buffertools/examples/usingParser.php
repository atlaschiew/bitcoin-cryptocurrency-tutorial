<?php

require __DIR__ . "/../vendor/autoload.php";

use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\Parser;

// Parsers read Buffers
$buffer = new Buffer('abcd01020304');
$parser = new Parser($buffer);

// Call readBytes to unpack the data

/** @var Buffer[] $set */
$set = [
    $parser->readBytes(1),
    $parser->readBytes(1),
    $parser->readBytes(1),
    $parser->readBytes(4)
];

foreach ($set as $item) {
    echo $item->getBinary() . PHP_EOL;
}
