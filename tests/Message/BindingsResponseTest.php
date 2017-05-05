<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 05.05.2017
 */

namespace Sberbank\Tests\Message;

use Mockery;
use Sberbank\Message\BindingsResponse;
use Sberbank\Tests\SberbankTestCase;

class BindingsResponseTest extends SberbankTestCase
{
    public function testConstruct()
    {
        $data = ['example' => 'value', 'foo' => 'bar'];
        $response = new BindingsResponse($this->getMockRequest(), $data);

        $this->assertEquals($data, $response->getData());
    }

    public function testBindingsResponseSuccess()
    {
        $data = $this->getMockAsArray('BindingsSuccess');
        $response = new BindingsResponse($this->getMockRequest(), $data);

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('', $response->getErrorMessage());
        $this->assertTrue(is_array($response->getBindings()));
        $this->assertTrue(count($response->getBindings()) === 1);

        $binding = $response->getBindings()[0];
        $this->assertInstanceOf('\Sberbank\Entity\Binding', $binding);
        $this->assertEquals('fd3afc57-c6d0-4e08-aaef-1b7cfeb093dc', $binding->getBindingId());
    }

    public function testBindingsResponseFailure()
    {
        $data = $this->getMockAsArray('BindingsError');
        $response = new BindingsResponse($this->getMockRequest(), $data);

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('Информация не найдена', $response->getErrorMessage());
        $this->assertEquals('Информация не найдена', $response->getErrorMessageByCode());
        $this->assertTrue(is_array($response->getBindings()));
        $this->assertTrue(empty($response->getBindings()));
    }
}