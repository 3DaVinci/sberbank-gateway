<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 17.05.2017
 */

namespace Sberbank\Tests\Message;

use Sberbank\Message\BindCardResponse;
use Sberbank\Tests\SberbankTestCase;

class BindCardResponseTest extends SberbankTestCase
{
    public function testConstruct()
    {
        $data = ['example' => 'value', 'foo' => 'bar'];
        $response = new BindCardResponse($this->getMockRequest(), $data);

        $this->assertEquals($data, $response->getData());
    }

    public function testBindCardResponseSuccess()
    {
        $data = $this->getMockAsArray('BindCardSuccess');
        $response = new BindCardResponse($this->getMockRequest(), $data);

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('', $response->getErrorMessage());
    }

    public function testBindingsResponseFailure()
    {
        $data = $this->getMockAsArray('BindCardError');
        $response = new BindCardResponse($this->getMockRequest(), $data);

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('Binding is active', $response->getErrorMessage());
        $this->assertEquals('Связка не найдена или имеет неверное состояние', $response->getErrorMessageByCode());
    }
}