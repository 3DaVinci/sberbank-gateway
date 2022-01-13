<?php

namespace Entity;

use Sberbank\Entity\Item;
use Sberbank\Entity\OrderBundle;
use PHPUnit\Framework\TestCase;

class OrderBundleTest extends TestCase
{
    public function testConstruct()
    {
        $item = new Item();
        $orderBundle = new OrderBundle([
            'orderCreationDate' => '2022-01-01T01:01:01',
            'customerDetails' => [],
            'cartItems' => [$item],
        ]);

        $this->assertEquals('2022-01-01T01:01:01', $orderBundle->getOrderCreationDate());
        $this->assertEquals([], $orderBundle->getCustomerDetails());
        $this->assertArrayHasKey('items', $orderBundle->getCartItems());
    }

    public function testSetOrderCreationDate()
    {
        $orderBundle = new OrderBundle();
        $orderBundle->setOrderCreationDate('2022-01-01T01:01:01');
        $this->assertEquals('2022-01-01T01:01:01', $orderBundle->getOrderCreationDate());
    }

    public function testSetCustomerDetails()
    {
        $orderBundle = new OrderBundle();
        $orderBundle->setCustomerDetails(['name' => 'customer']);
        $this->assertArrayHasKey('name', $details = $orderBundle->getCustomerDetails());
        $this->assertEquals('customer', $details['name']);
    }

    public function testSetCartItems()
    {
        $cartItem = new Item([
            'positionId' => 1,
            'name' => 'product',
            'quantity' => ['value' => 1, 'measure'=> 'шт.'],
            'itemCode' => '11112222',
            'itemPrice' => 12350
        ]);
        $orderBundle = new OrderBundle();
        $orderBundle->setCartItems([$cartItem]);

        $this->assertArrayHasKey('items', $items = $orderBundle->getCartItems());
        $this->assertCount(1, $items['items']);
        $this->assertEquals('product', $items['items'][0]['name']);
    }
}
