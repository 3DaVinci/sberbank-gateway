<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 05.05.2017
 */

namespace Sberbank\Tests\Message;

use Mockery;
use Sberbank\Message\RegisterOrderResponse;
use Sberbank\Tests\SberbankTestCase;

class RegisterOrderResponseTest extends SberbankTestCase
{
    public function testConstruct()
    {
        $data = ['example' => 'value', 'foo' => 'bar'];
        $response = new RegisterOrderResponse($this->getMockRequest(), $data);

        $this->assertEquals($data, $response->getData());
    }

    public function testRegisterOrderResponseSuccess()
    {
        $data = $this->getMockAsArray('RegisterOrderSuccess');
        $response = new RegisterOrderResponse($this->getMockRequest(), $data);

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('', $response->getErrorMessage());
        $this->assertEquals('', $response->getErrorMessageByCode());
        $this->assertEquals('70906e55-7114-41d6-8332-4609dc6590f4', $response->getOrderId());
        $this->assertEquals('https://server/application_context/merchants/test/payment_ru.html?mdOrder=70906e55-7114-41d6-8332-4609dc6590f4', $response->getFormUrl());
    }

    public function testRegisterOrderResponseFailure()
    {
        $data = $this->getMockAsArray('RegisterOrderError');
        $response = new RegisterOrderResponse($this->getMockRequest(), $data);

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('Доступ запрещён', $response->getErrorMessage());
        $this->assertEquals('Ошибка значение параметра запроса', $response->getErrorMessageByCode());
        $this->assertNull($response->getOrderId());
        $this->assertNull($response->getFormUrl());
    }
}