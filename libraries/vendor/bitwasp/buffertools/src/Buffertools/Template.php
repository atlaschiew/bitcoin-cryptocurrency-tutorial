<?php

declare(strict_types=1);

namespace BitWasp\Buffertools;

use BitWasp\Buffertools\Types\TypeInterface;

class Template implements \Countable
{
    /**
     * @var TypeInterface[]
     */
    private $template = [];

    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * {@inheritdoc}
     * @see \Countable::count()
     * @return int
     */
    public function count(): int
    {
        return count($this->template);
    }

    /**
     * Return an array of type serializers in the template
     *
     * @return Types\TypeInterface[]
     */
    public function getItems(): array
    {
        return $this->template;
    }

    /**
     * Add a new TypeInterface to the Template
     *
     * @param  TypeInterface $item
     * @return Template
     */
    public function addItem(TypeInterface $item): Template
    {
        $this->template[] = $item;
        return $this;
    }

    /**
     * Parse a sequence of objects from binary, using the current template.
     *
     * @param  Parser $parser
     * @return mixed[]|Buffer[]|int[]|string[]
     */
    public function parse(Parser $parser): array
    {
        if (0 == count($this->template)) {
            throw new \RuntimeException('No items in template');
        }

        $values = [];
        foreach ($this->template as $reader) {
            $values[] = $reader->read($parser);
        }

        return $values;
    }

    /**
     * Write the array of $items to binary according to the template. They must
     * each be an instance of Buffer or implement SerializableInterface.
     *
     * @param  array $items
     * @return BufferInterface
     */
    public function write(array $items): BufferInterface
    {
        if (count($items) != count($this->template)) {
            throw new \RuntimeException('Number of items must match template');
        }

        $binary = '';

        foreach ($this->template as $serializer) {
            $item = array_shift($items);
            $binary .= $serializer->write($item);
        }

        return new Buffer($binary);
    }
}
