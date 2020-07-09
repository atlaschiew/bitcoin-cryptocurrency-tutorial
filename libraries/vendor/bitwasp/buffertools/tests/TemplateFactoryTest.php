<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Tests;

use BitWasp\Buffertools\TemplateFactory;
use BitWasp\Buffertools\Types\VarInt;
use BitWasp\Buffertools\Types\VarString;
use BitWasp\Buffertools\Types\Vector;

class TemplateFactoryTest extends BinaryTest
{
    /**
     * @return array
     */
    public function getTestVectors(): array
    {
        $vectors = [];

        for ($i = 8; $i <= 256; $i = $i * 2) {
            foreach (array('', 'le') as $byteOrder) {
                $vectors[] = [
                    'uint' . $i . $byteOrder,
                    '\BitWasp\Buffertools\Types\Uint' . $i,
                ];
                $vectors[] = [
                    'int' . $i . $byteOrder,
                    '\BitWasp\Buffertools\Types\Int' . $i,
                ];
            }
        }

        $vectors[] = [
            'varint',
            VarInt::class
        ];

        $vectors[] = [
            'varstring',
            VarString::class
        ];

        return $vectors;
    }

    /**
     * @dataProvider getTestVectors
     * @param string $function
     * @param string $eClass
     */
    public function testTemplateUint(string $function, string $eClass)
    {
        $factory = new TemplateFactory(null);
        $factory->$function();
        $template = $factory->getTemplate();
        $this->assertEquals(1, count($template));
        $template = $factory->getTemplate()->getItems();
        $this->assertInstanceOf($eClass, $template[0]);
    }

    public function testVector()
    {
        $factory = new TemplateFactory(null);
        $factory->vector(
            function () {
                return;
            }
        );
        $template = $factory->getTemplate();
        $this->assertEquals(1, count($template));
        $template = $factory->getTemplate()->getItems();
        $this->assertInstanceOf(Vector::class, $template[0]);
    }
}
