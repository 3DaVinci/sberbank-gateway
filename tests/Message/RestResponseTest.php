<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */

namespace Sberbank\Tests\Message;

use PHPUnit\Framework\TestCase;
use Mockery;

class RestResponseTest extends TestCase
{
    private $response;

    public function setUp()
    {
        $this->response = Mockery::mock('\Sberbank\Message\RestResponse')->makePartial();
    }

    public function testConstruct()
    {
        $data = ['foo' => 'bar'];
        $request = $this->getMockRequest();
        $this->response = Mockery::mock('\Sberbank\Message\RestResponse', [$request, $data])->makePartial();

        $this->assertSame($request, $this->response->getRequest());
        $this->assertSame($data, $this->response->getData());
    }

    public function testGetCode()
    {
        $data = ['foo' => 'bar'];
        $request = $this->getMockRequest();
        $this->response = Mockery::mock('\Sberbank\Message\RestResponse', [$request, $data])->makePartial();
        $this->assertEquals(200, $this->response->getCode());

        $data = ['foo' => 'bar'];
        $request = $this->getMockRequest();
        $this->response = Mockery::mock('\Sberbank\Message\RestResponse', [$request, $data, 404])->makePartial();
        $this->assertEquals(404, $this->response->getCode());
    }

    public function testIsSuccessful()
    {
        $data = ['foo' => 'bar'];
        $request = $this->getMockRequest();
        $this->response = Mockery::mock('\Sberbank\Message\RestResponse', [$request, $data])->makePartial();
        $this->assertTrue($this->response->isSuccessful());

        $data = ['errorCode' => 0];
        $this->response = Mockery::mock('\Sberbank\Message\RestResponse', [$request, $data])->makePartial();
        $this->assertTrue($this->response->isSuccessful());

        $data = ['errorCode' => 10];
        $this->response = Mockery::mock('\Sberbank\Message\RestResponse', [$request, $data])->makePartial();
        $this->assertFalse($this->response->isSuccessful());
    }

    public function testDefaultMethods()
    {
        $this->assertNull($this->response->getData());
        $this->assertNull($this->response->getCode());
        $this->assertNull($this->response->getRequest());
        $this->assertFalse($this->response->isSuccessful());
    }

    private function getMockRequest()
    {
        return Mockery::mock('\Sberbank\Message\RequestInterface');
    }
}