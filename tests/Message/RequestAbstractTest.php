<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */

namespace Sberbank\Tests\Message;

use PHPUnit\Framework\TestCase;
use Mockery;

class RequestAbstractTest extends TestCase
{
    private $request;

    public function setUp()
    {
        $this->request = Mockery::mock('\Sberbank\Message\RequestAbstract')->makePartial();
    }

    public function testInitializeWithParams()
    {
        $this->assertSame($this->request, $this->request->initialize(['password' => '123456']));

        $password = $this->request->getParameter('password');
        $this->assertEquals('123456', $password);
    }

    public function testPassword()
    {
        $this->assertSame($this->request, $this->request->setPassword('123456'));
        $password = $this->request->getParameter('password');
        $this->assertEquals('123456', $password);
    }

    public function testUserName()
    {
        $this->assertSame($this->request, $this->request->setUserName('Andy'));
        $userName = $this->request->getParameter('userName');
        $this->assertEquals('Andy', $userName);
    }

    public function testTestMode()
    {
        $this->assertSame($this->request, $this->request->setTestMode(true));
        $testMode = $this->request->getParameter('testMode');
        $this->assertTrue($testMode);

        $this->request->setTestMode(false);
        $testMode = $this->request->getTestMode();
        $this->assertFalse($testMode);
    }

    public function testGetUrl()
    {
        $this->request->shouldReceive('getMethodName')->andReturn('foo');
        $url = $this->request->getUrl();
        $this->assertTrue(is_string($url));
        $this->assertNotEmpty($url);
    }

    public function testGetParameters()
    {
        $this->request->initialize(['password' => '123456']);
        $parameters = $this->request->getParameters();
        $this->assertTrue(is_array($parameters));
    }

    public function testValidate()
    {
        $this->expectException(\Sberbank\Exception\InvalidRequestException::class);
        $this->request->validate();

        $this->request->initialize([
            'userName' => 'Andy',
            'password' => '123456',
        ]);
        $this->request->validate();
    }

    public function testInitialize()
    {
        $this->request->initialize([
            'userName' => 'Andy',
            'password' => '123456',
            'unresolved_parameter' => '1'
        ]);
        $unresolvedParameter = $this->request->getParameter('unresolved_parameter');
        $this->assertTrue(is_null($unresolvedParameter));
    }
}