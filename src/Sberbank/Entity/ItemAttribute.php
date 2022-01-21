<?php

namespace Sberbank\Entity;

class ItemAttribute extends AbstractEntity
{
    const FIELD_PAYMENT_METHOD = 'paymentMethod';
    const FIELD_PAYMENT_OBJECT = 'paymentObject';

    const PAYMENT_METHOD_FULL = 1;
    const PAYMENT_OBJECT_PRODUCT = 1;
    const PAYMENT_OBJECT_SERVICE = 4;

    protected string $name;

    protected string $value;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ItemAttribute
     */
    public function setName(string $name): ItemAttribute
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return ItemAttribute
     */
    public function setValue(string $value): ItemAttribute
    {
        $this->value = $value;
        return $this;
    }


}