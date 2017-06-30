<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 05.05.2017
 */

namespace Sberbank\Tests\Message;

use Sberbank\Message\OrderStatusResponse;
use Sberbank\Tests\SberbankTestCase;

class OrderStatusResponseTest extends SberbankTestCase
{
    public function testConstruct()
    {
        $data = ['example' => 'value', 'foo' => 'bar'];
        $response = new OrderStatusResponse($this->getMockRequest(), $data);

        $this->assertEquals($data, $response->getData());
    }

    public function testOrderStatusResponseSuccess()
    {
        $data = $this->getMockAsArray('OrderStatusSuccess');
        $response = new OrderStatusResponse($this->getMockRequest(), $data);

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('', $response->getErrorMessage());
        $this->assertEquals('Обработка запроса прошла без системных ошибок', $response->getErrorMessageByCode());
        $this->assertEquals('Проведена полная авторизация суммы заказа', $response->getStatus());
    }

    public function testOrderStatusResponseFailure()
    {
        $data = $this->getMockAsArray('OrderStatusError');
        $response = new OrderStatusResponse($this->getMockRequest(), $data);

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('Доступ запрещён', $response->getErrorMessage());
        $this->assertEquals('Доступ запрещён', $response->getErrorMessageByCode());
        $this->assertEquals('', $response->getStatus());
    }
}