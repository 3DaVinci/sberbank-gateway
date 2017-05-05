<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 05.05.2017
 */

namespace Sberbank\Tests\Message;

use PHPUnit\Framework\TestCase;
use Mockery;

class BindingsRequestTest extends TestCase
{
    private $request;

    public function setUp()
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
        $this->expectException(\Sberbank\Exception\InvalidRequestException::class);
        $this->request
            ->setPassword('123456')
            ->setUserName('user_name');
        $this->request->validate();

        // Not Exception
        $this->requestsetClientId('18547');
        $this->request->validate();
    }

    public function testGetMethodName()
    {
        $method = $this->request->getMethodName();
        $this->assertTrue(is_string($method));
        $this->assertNotEmpty($method);
    }
}