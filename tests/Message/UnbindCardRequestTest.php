<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 17.05.2017
 */

namespace Sberbank\Tests\Message;

use PHPUnit\Framework\TestCase;
use Mockery;
use Sberbank\Exception\InvalidRequestException;

class UnbindCardRequestTest extends TestCase
{
    private Mockery\MockInterface $request;

    public function setUp(): void
    {
        $this->request = Mockery::mock('\Sberbank\Message\UnbindCardRequest')->makePartial();
    }

    public function testClientId()
    {
        $this->assertSame($this->request, $this->request->setBindingId('9cead45e-19c4-4102-9940-37678888bac4'));
        $result = $this->request->getParameter('bindingId');
        $this->assertEquals('9cead45e-19c4-4102-9940-37678888bac4', $result);
    }

    public function testValidate()
    {
        $this->expectException(InvalidRequestException::class);
        $this->request
            ->setPassword('123456')
            ->setUserName('user_name');
        $this->request->validate();

        // Not Exception
        $this->request->setBindingId('9cead45e-19c4-4102-9940-37678888bac4');
        $this->request->validate();
    }

    public function testGetMethodName()
    {
        $method = $this->request->getMethodName();
        $this->assertTrue(is_string($method));
        $this->assertNotEmpty($method);
    }
}