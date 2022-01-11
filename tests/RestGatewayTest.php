<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 02.05.2017
 */

namespace Sberbank\Tests;

use Sberbank\Exception\InvalidRequestException;
use Sberbank\Message\BindCardRequest;
use Sberbank\Message\BindingsRequest;
use Sberbank\Message\OrderStatusRequest;
use Sberbank\Message\PaymentCancellationRequest;
use Sberbank\Message\RefundRequest;
use Sberbank\Message\RegisterOrderRequest;
use Sberbank\Message\RestResponse;
use Sberbank\RestGateway;

class RestGatewayTest extends SberbankTestCase
{
    /**
     * @var RestGateway
     */
    public RestGateway $gateway;

    private array $globalParams = [
        'password' => 'password',
        'userName' => 'username',
        'testMode' => true,
    ];

    /**
     * @param string $mock
     */
    private function setGateway(string $mock)
    {
        $this->gateway = new RestGateway(
            $this->globalParams,
            $this->setMockSberbankClient($mock)
        );
    }

    public function testRegisterOrderRequestSuccess()
    {
        $this->setGateway('RegisterOrderSuccess');

        /** @var RegisterOrderRequest $request */
        $request = $this->gateway->registerOrder([
            'orderNumber' => 1,
            'amount' => 12000,
            'returnUrl' => 'https://server/applicaton_context/finish.html'
        ]);

        $request->validate();

        /** @var RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertTrue($response->isSuccessful());
    }

    public function testRegisterOrderRequestError()
    {
        $this->setGateway('RegisterOrderError');
        /** @var RegisterOrderRequest $request */
        $request = $this->gateway->registerOrder([
            'orderNumber' => 1,
            'returnUrl' => 'https://server/applicaton_context/finish.html'
        ]);

        $this->expectException(InvalidRequestException::class);
        $request->validate();

        /** @var RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertFalse($response->isSuccessful());
    }

    public function testOrderStatusSuccess()
    {
        $this->setGateway('OrderStatusSuccess');
        /** @var OrderStatusRequest $request */
        $request = $this->gateway->orderStatus([
            'orderId' => 'b8d70aa7-bfb3-4f94-b7bb-aec7273e1fce'
        ]);

        $request->validate();

        /** @var RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertTrue($response->isSuccessful());
    }

    public function testOrderStatusError()
    {
        $this->setGateway('OrderStatusError');
        /** @var OrderStatusRequest $request */
        $request = $this->gateway->orderStatus();

        $this->expectException(InvalidRequestException::class);
        $request->validate();

        /** @var RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertFalse($response->isSuccessful());
    }

    public function testPaymentCancellationSuccess()
    {
        $this->setGateway('PaymentCancellationSuccess');
        /** @var PaymentCancellationRequest $request */
        $request = $this->gateway->paymentCancellation([
            'orderId' => 'b8d70aa7-bfb3-4f94-b7bb-aec7273e1fce'
        ]);

        $request->validate();

        /** @var RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertTrue($response->isSuccessful());
    }

    public function testPaymentCancellationError()
    {
        $this->setGateway('PaymentCancellationError');
        /** @var PaymentCancellationRequest $request */
        $request = $this->gateway->paymentCancellation();

        $this->expectException(InvalidRequestException::class);
        $request->validate();

        /** @var RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertFalse($response->isSuccessful());
    }

    public function testRefundSuccess()
    {
        $this->setGateway('RefundSuccess');
        /** @var RefundRequest $request */
        $request = $this->gateway->refund([
            'orderId' => 'b8d70aa7-bfb3-4f94-b7bb-aec7273e1fce',
            'amount' => 120000
        ]);

        $request->validate();

        /** @var RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertTrue($response->isSuccessful());
    }

    public function testRefundError()
    {
        $this->setGateway('RefundError');
        /** @var RefundRequest $request */
        $request = $this->gateway->refund();

        $this->expectException(InvalidRequestException::class);
        $request->validate();

        /** @var RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertFalse($response->isSuccessful());
    }

    public function testBindingsSuccess()
    {
        $this->setGateway('BindingsSuccess');
        /** @var BindingsRequest $request */
        $request = $this->gateway->getBindings('22');
        $request->validate();

        /** @var RestResponse $response */
        $response = $request->send();


        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertTrue($response->isSuccessful());
    }

    public function testBindingsError()
    {
        $this->setGateway('BindingsError');
        /** @var BindingsRequest $request */
        $request = $this->gateway->getBindings('13');

        /** @var RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertFalse($response->isSuccessful());
    }

    public function testBindCardSuccess()
    {
        $this->setGateway('BindCardSuccess');
        /** @var BindCardRequest $request */
        $request = $this->gateway->getBindCard('9cead45e-19c4-4102-9940-37678888bac4');
        $request->validate();

        /** @var RestResponse $response */
        $response = $request->send();


        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertTrue($response->isSuccessful());
    }

    public function testBindCardError()
    {
        $this->setGateway('BindCardError');
        /** @var BindingsRequest $request */
        $request = $this->gateway->getBindCard('9cead45e-19c4-4102-9940-37678888bac4');

        /** @var RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertFalse($response->isSuccessful());
    }
    public function testUnbindCardSuccess()
    {
        $this->setGateway('UnbindCardSuccess');
        /** @var BindCardRequest $request */
        $request = $this->gateway->getUnbindCard('9cead45e-19c4-4102-9940-37678888bac4');
        $request->validate();

        /** @var RestResponse $response */
        $response = $request->send();


        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertTrue($response->isSuccessful());
    }

    public function testUnbindCardError()
    {
        $this->setGateway('UnbindCardError');
        /** @var BindingsRequest $request */
        $request = $this->gateway->getUnbindCard('9cead45e-19c4-4102-9940-37678888bac4');

        /** @var RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertFalse($response->isSuccessful());
    }
}