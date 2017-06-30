<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 30.05.2017
 */

namespace Sberbank\Tests\Message;

use Sberbank\Message\PaymentCancellationResponse;
use Sberbank\Tests\SberbankTestCase;

class PaymentCancellationResponseTest extends SberbankTestCase
{
    public function testConstruct()
    {
        $data = ['example' => 'value', 'foo' => 'bar'];
        $response = new PaymentCancellationResponse($this->getMockRequest(), $data);

        $this->assertEquals($data, $response->getData());
    }

    public function testPaymentCancellationResponseSuccess()
    {
        $data = $this->getMockAsArray('PaymentCancellationSuccess');
        $response = new PaymentCancellationResponse($this->getMockRequest(), $data);

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('', $response->getErrorMessage());
        $this->assertEquals('Обработка запроса прошла без системных ошибок', $response->getErrorMessageByCode());
    }

    public function testPaymentCancellationResponseFailure()
    {
        $data = $this->getMockAsArray('PaymentCancellationError');
        $response = new PaymentCancellationResponse($this->getMockRequest(), $data);

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('Незарегистрированный OrderId', $response->getErrorMessage());
        $this->assertEquals('Незарегистрированный OrderId', $response->getErrorMessageByCode());
    }
}