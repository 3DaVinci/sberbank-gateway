<?php

namespace Entity;

use Sberbank\Entity\Item;
use PHPUnit\Framework\TestCase;
use Sberbank\Entity\ItemAttribute;
use Sberbank\Entity\Tax;

class ItemTest extends TestCase
{

    public function testSetItemAttributes()
    {
        $item = new Item();
        $attribute = new ItemAttribute();
        $item->setItemAttributes([$attribute]);
        $this->assertArrayHasKey('attributes', $attributes = $item->getItemAttributes());
        $this->assertCount(1, $attributes['attributes']);
        $this->assertEquals($attribute->toArray(), $attributes['attributes'][0]);
    }

    public function testGetQuantity()
    {
        $item = new Item();
        $this->assertArrayHasKey('value', $item->getQuantity());
        $this->assertArrayHasKey('measure', $item->getQuantity());
        $quantity = $item->getQuantity();
        $this->assertEquals(1, $quantity['value']);
        $this->assertEquals('шт', $quantity['measure']);
        $quantity = ['value' => 10, 'measure' =>'м'];
        $item->setQuantity($quantity);
        $this->assertEquals(10, $quantity['value']);
        $this->assertEquals('м', $quantity['measure']);
    }

    public function testGetPositionId()
    {
        $item = new Item();
        $item->setPositionId('10');
        $this->assertEquals('10', $item->getPositionId());
    }

    public function testGetTax()
    {
        $tax = new Tax();
        $item = new Item();
        $item->setTax($tax);
        $this->assertEquals($tax, $item->getTax());
    }

    public function testGetItemCode()
    {
        $item = new Item();
        $item->setItemCode('10');
        $this->assertEquals('10', $item->getItemCode());
    }

    public function testGetItemPrice()
    {
        $item = new Item();
        $item->setItemPrice(10);
        $this->assertEquals(10, $item->getItemPrice());
    }

    public function testGetName()
    {
        $item = new Item();
        $item->setName('product');
        $this->assertEquals('product', $item->getName());
    }
}
