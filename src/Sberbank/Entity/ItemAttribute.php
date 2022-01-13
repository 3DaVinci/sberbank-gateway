<?php

namespace Sberbank\Entity;

class ItemAttribute extends AbstractEntity
{
    const PAYMENT_METHOD_FULL = 1;
    const PAYMENT_OBJECT_PRODUCT = 1;
    const PAYMENT_OBJECT_SERVICE = 4;

    protected int $paymentMethod;

    protected int $paymentObject;

    /**
     * @return int
     */
    public function getPaymentMethod(): int
    {
        return $this->paymentMethod;
    }

    /**
     * @param int $paymentMethod
     * @return ItemAttribute
     */
    public function setPaymentMethod(int $paymentMethod): ItemAttribute
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    /**
     * @return int
     */
    public function getPaymentObject(): int
    {
        return $this->paymentObject;
    }

    /**
     * @param int $paymentObject
     * @return ItemAttribute
     */
    public function setPaymentObject(int $paymentObject): ItemAttribute
    {
        $this->paymentObject = $paymentObject;
        return $this;
    }
}