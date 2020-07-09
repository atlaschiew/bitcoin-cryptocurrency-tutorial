<?php

declare(strict_types=1);

namespace BitWasp\Buffertools;

class TemplateFactory
{
    /**
     * @var \BitWasp\Buffertools\Template
     */
    private $template;

    /**
     * @var TypeFactoryInterface
     */
    private $types;

    /**
     * TemplateFactory constructor.
     * @param Template|null $template
     * @param TypeFactoryInterface|null $typeFactory
     */
    public function __construct(Template $template = null, TypeFactoryInterface $typeFactory = null)
    {
        $this->template = $template ?: new Template();
        $this->types = $typeFactory ?: new CachingTypeFactory();
    }

    /**
     * Return the Template as it stands.
     *
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Add a Uint8 serializer to the template
     *
     * @return TemplateFactory
     */
    public function uint8()
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a little-endian Uint8 serializer to the template
     *
     * @return TemplateFactory
     */
    public function uint8le(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a Uint16 serializer to the template
     *
     * @return TemplateFactory
     */
    public function uint16(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a little-endian Uint16 serializer to the template
     *
     * @return TemplateFactory
     */
    public function uint16le(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a Uint32 serializer to the template
     *
     * @return TemplateFactory
     */
    public function uint32(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a little-endian Uint32 serializer to the template
     *
     * @return TemplateFactory
     */
    public function uint32le(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a Uint64 serializer to the template
     *
     * @return TemplateFactory
     */
    public function uint64(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a little-endian Uint64 serializer to the template
     *
     * @return TemplateFactory
     */
    public function uint64le(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a Uint128 serializer to the template
     *
     * @return TemplateFactory
     */
    public function uint128(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a little-endian Uint128 serializer to the template
     *
     * @return TemplateFactory
     */
    public function uint128le(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a Uint256 serializer to the template
     *
     * @return TemplateFactory
     */
    public function uint256(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a little-endian Uint256 serializer to the template
     *
     * @return TemplateFactory
     */
    public function uint256le(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a int8 serializer to the template
     *
     * @return TemplateFactory
     */
    public function int8(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a little-endian Int8 serializer to the template
     *
     * @return TemplateFactory
     */
    public function int8le(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a int16 serializer to the template
     *
     * @return TemplateFactory
     */
    public function int16(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a little-endian Int16 serializer to the template
     *
     * @return TemplateFactory
     */
    public function int16le(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a int32 serializer to the template
     *
     * @return TemplateFactory
     */
    public function int32(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a little-endian Int serializer to the template
     *
     * @return TemplateFactory
     */
    public function int32le(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a int64 serializer to the template
     *
     * @return TemplateFactory
     */
    public function int64(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a little-endian Int64 serializer to the template
     *
     * @return TemplateFactory
     */
    public function int64le(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a int128 serializer to the template
     *
     * @return TemplateFactory
     */
    public function int128(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a little-endian Int128 serializer to the template
     *
     * @return TemplateFactory
     */
    public function int128le(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a int256 serializer to the template
     *
     * @return TemplateFactory
     */
    public function int256(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a little-endian Int256 serializer to the template
     *
     * @return TemplateFactory
     */
    public function int256le(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a VarInt serializer to the template
     *
     * @return TemplateFactory
     */
    public function varint(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a VarString serializer to the template
     *
     * @return TemplateFactory
     */
    public function varstring(): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}());
        return $this;
    }

    /**
     * Add a byte string serializer to the template. This serializer requires a length to
     * pad/truncate to.
     *
     * @param  int $length
     * @return TemplateFactory
     */
    public function bytestring(int $length): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}($length));
        return $this;
    }

    /**
     * Add a little-endian byte string serializer to the template. This serializer requires
     * a length to pad/truncate to.
     *
     * @param  int $length
     * @return TemplateFactory
     */
    public function bytestringle(int $length): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}($length));
        return $this;
    }

    /**
     * Add a vector serializer to the template. A $readHandler must be provided if the
     * template will be used to deserialize a vector, since it's contents are not known.
     *
     * The $readHandler should operate on the parser reference, reading the bytes for each
     * item in the collection.
     *
     * @param  callable $readHandler
     * @return TemplateFactory
     */
    public function vector(callable $readHandler): TemplateFactory
    {
        $this->template->addItem($this->types->{__FUNCTION__}($readHandler));
        return $this;
    }
}
