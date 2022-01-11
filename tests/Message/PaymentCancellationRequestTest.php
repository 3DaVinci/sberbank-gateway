<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 30.05.2017
 */

namespace Sberbank\Tests\Message;

use PHPUnit\Framework\TestCase;
use Mockery;
use Sberbank\Exception\InvalidRequestException;

class PaymentCancellationRequestTest extends TestCase
{
    private Mockery\MockInterface $request;

    public function setUp(): void
    {
        $this->request = Mockery::mock('\Sberbank\Message\PaymentCancellationRequest')->makePartial();
    }

    public function testOrderId()
    {
        $this->assertSame($this->request, $this->request->setOrderId('b8d70aa7-bfb3-4f94-b7bb-aec7273e1fce'));
        $orderId = $this->request->getParameter('orderId');
        $this->assertEquals('b8d70aa7-bfb3-4f94-b7bb-aec7273e1fce', $orderId);
    }

    public function testValidate()
    {
        $this->expectException(InvalidRequestException::class);
        $this->request
            ->setPassword('123456')
            ->setUserName('user_name');
        $this->request->validate();

        // Not Exception
        $this->request->setOrderId('b8d70aa7-bfb3-4f94-b7bb-aec7273e1fce');
        $this->request->validate();
    }

    public function testGetMethodName()
    {
        $method = $this->request->getMethodName();
        $this->assertTrue(is_string($method));
        $this->assertNotEmpty($method);
    }
}