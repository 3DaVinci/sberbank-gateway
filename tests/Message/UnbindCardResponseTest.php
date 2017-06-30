<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 17.05.2017
 */

namespace Sberbank\Tests\Message;

use Sberbank\Message\UnbindCardResponse;
use Sberbank\Tests\SberbankTestCase;

class UnbindCardResponseTest extends SberbankTestCase
{
    public function testConstruct()
    {
        $data = ['example' => 'value', 'foo' => 'bar'];
        $response = new UnbindCardResponse($this->getMockRequest(), $data);

        $this->assertEquals($data, $response->getData());
    }

    public function testUnbindCardResponseSuccess()
    {
        $data = $this->getMockAsArray('BindCardSuccess');
        $response = new UnbindCardResponse($this->getMockRequest(), $data);

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('', $response->getErrorMessage());
    }

    public function testBindingsResponseFailure()
    {
        $data = $this->getMockAsArray('BindCardError');
        $response = new UnbindCardResponse($this->getMockRequest(), $data);

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('Binding is active', $response->getErrorMessage());
        $this->assertEquals('Связка не найдена или имеет неверное состояние', $response->getErrorMessageByCode());
    }
}