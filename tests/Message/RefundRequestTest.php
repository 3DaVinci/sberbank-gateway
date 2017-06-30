<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 30.05.2017
 */

namespace Sberbank\Tests\Message;

use PHPUnit\Framework\TestCase;
use Mockery;

class RefundRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        $this->request = Mockery::mock('\Sberbank\Message\RefundRequest')->makePartial();
    }

    public function testOrderId()
    {
        $this->assertSame($this->request, $this->request->setOrderId('b8d70aa7-bfb3-4f94-b7bb-aec7273e1fce'));
        $orderId = $this->request->getParameter('orderId');
        $this->assertEquals('b8d70aa7-bfb3-4f94-b7bb-aec7273e1fce', $orderId);
    }

    public function testAmount()
    {
        $this->assertSame($this->request, $this->request->setAmount(155000));
        $amount = $this->request->getParameter('amount');
        $this->assertEquals(155000, $amount);
    }

    public function testValidate()
    {
        $this->expectException(\Sberbank\Exception\InvalidRequestException::class);
        $this->request
            ->setPassword('123456')
            ->setUserName('user_name');
        $this->request->validate();

        $this->expectException(\Sberbank\Exception\InvalidRequestException::class);
        $this->request->setOrderId('b8d70aa7-bfb3-4f94-b7bb-aec7273e1fce');
        $this->request->validate();

        // Not Exception
        $this->request->setAmount(155000);
        $this->request->validate();
    }

    public function testGetMethodName()
    {
        $method = $this->request->getMethodName();
        $this->assertTrue(is_string($method));
        $this->assertNotEmpty($method);
    }
}