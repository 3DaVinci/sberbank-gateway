<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 05.05.2017
 */

namespace Sberbank\Tests\Message;

use PHPUnit\Framework\TestCase;
use Mockery;
use Sberbank\Exception\InvalidRequestException;

class BindingsRequestTest extends TestCase
{
    private Mockery\MockInterface $request;

    public function setUp() : void
    {
        $this->request = Mockery::mock('\Sberbank\Message\BindingsRequest')->makePartial();
    }

    public function testClientId()
    {
        $this->assertSame($this->request, $this->request->setClientId('18547'));
        $result = $this->request->getParameter('clientId');
        $this->assertEquals('18547', $result);
    }

    public function testValidate()
    {
        $this->expectException(InvalidRequestException::class);
        $this->request
            ->setPassword('123456')
            ->setUserName('user_name');
        $this->request->validate();

        // Not Exception
        $this->request->setClientId('18547');
        $this->request->validate();
    }

    public function testGetMethodName()
    {
        $method = $this->request->getMethodName();
        $this->assertTrue(is_string($method));
        $this->assertNotEmpty($method);
    }
}