<?php

require __DIR__ . "/../vendor/autoload.php";

use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\Parser;
use BitWasp\Buffertools\TemplateFactory;

$structure = (object) [
    'hash' => hash('sha256', 'abc'),
    'message_id' => 9123,
    'message' => "Hi there! What's up?"
];

// Templates are read/write
$template = (new TemplateFactory)
    ->bytestring(32)
    ->uint32()
    ->varstring()
    ->getTemplate();

// Write the structure
$binary = $template->write([
    Buffer::hex($structure->hash),
    $structure->message_id,
    new Buffer($structure->message)
]);

echo $binary->getHex() . "\n";

// Use the template to read resulting Buffer
$parsed = $template->parse(new Parser($binary));

print_r($parsed);
