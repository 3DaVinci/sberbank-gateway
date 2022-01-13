<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */

namespace Sberbank\Tests\Message;

use Sberbank\Message\RestResponse;
use Sberbank\Tests\SberbankTestCase;
use Mockery;

class RestResponseTest extends SberbankTestCase
{
    /**
     * @var RestResponse
     */
    private $response;

    public function setUp(): void
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

    public function testGetErrorCode()
    {
        $code = $this->response->getErrorCode();
        $this->assertTrue(is_null($code));

        $request = $this->getMockRequest();
        $data = ['errorCode' => 10];
        $this->response = Mockery::mock('\Sberbank\Message\RestResponse', [$request, $data])->makePartial();
        $code = $this->response->getErrorCode();
        $this->assertEquals(10, $code);
    }

    public function testGetErrorMessage()
    {
        $message = $this->response->getErrorMessage();
        $this->assertTrue(is_string($message));
    }

    public function testDefaultMethods()
    {
        $this->assertNull($this->response->getData());
        $this->assertNull($this->response->getCode());
        $this->assertNull($this->response->getRequest());
        $this->assertFalse($this->response->isSuccessful());
    }
}