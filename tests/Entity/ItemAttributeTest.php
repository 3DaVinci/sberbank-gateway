<?php

namespace Entity;

use Sberbank\Entity\ItemAttribute;
use PHPUnit\Framework\TestCase;

class ItemAttributeTest extends TestCase
{

    public function testGetPaymentObject()
    {
        $attribute = new ItemAttribute([
            'paymentMethod' => ItemAttribute::PAYMENT_METHOD_FULL,
            'paymentObject' => ItemAttribute::PAYMENT_OBJECT_PRODUCT
        ]);

        $this->assertEquals(ItemAttribute::PAYMENT_OBJECT_PRODUCT, $attribute->getPaymentObject());
    }

    public function testGetPaymentMethod()
    {
        $attribute = new ItemAttribute([
            'paymentMethod' => ItemAttribute::PAYMENT_METHOD_FULL,
            'paymentObject' => ItemAttribute::PAYMENT_OBJECT_PRODUCT
        ]);

        $this->assertEquals(ItemAttribute::PAYMENT_METHOD_FULL, $attribute->getPaymentMethod());
    }
}
