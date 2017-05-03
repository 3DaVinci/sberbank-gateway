<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 02.05.2017
 */

namespace Sberbank\Tests;

use Sberbank\RestGateway;

class RestGatewayTest extends SberbankTestCase
{
    /**
     * @var RestGateway
     */
    public $gateway;

    public function setUp()
    {
        parent::setUp();

        $params = [
            'password' => 'password',
            'userName' => 'username',
            'testMode' => true,
        ];
        $this->gateway = new RestGateway(
            $params,
            $this->setMockSberbankClient([
                'RegisterOrderSuccess',
                'RegisterOrderError',
                'OrderStatusSuccess',
                'OrderStatusError'
            ])
        );
    }

    public function testRegisterOrderRequestSuccess()
    {
        /** @var \Sberbank\Message\RegisterOrderRequest $request */
        $request = $this->gateway->registerOrder([
            'orderNumber' => 1,
            'amount' => 12000,
            'returnUrl' => 'https://server/applicaton_context/finish.html'
        ]);

        $request->validate();

        /** @var \Sberbank\Message\RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertTrue($response->isSuccessful());
    }

    public function testRegisterOrderRequestError()
    {
        /** @var \Sberbank\Message\RegisterOrderRequest $request */
        $request = $this->gateway->registerOrder([
            'orderNumber' => 1,
            'returnUrl' => 'https://server/applicaton_context/finish.html'
        ]);

        $this->expectException(\Sberbank\Exception\InvalidRequestException::class);
        $request->validate();

        /** @var \Sberbank\Message\RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertFalse($response->isSuccessful());
    }

    public function testOrderStatusSuccess()
    {
        /** @var \Sberbank\Message\OrderStatusRequest $request */
        $request = $this->gateway->orderStatus([
            'orderId' => 'b8d70aa7-bfb3-4f94-b7bb-aec7273e1fce'
        ]);

        $request->validate();

        /** @var \Sberbank\Message\RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertTrue($response->isSuccessful());
    }

    public function testOrderStatusError()
    {
        /** @var \Sberbank\Message\OrderStatusRequest $request */
        $request = $this->gateway->orderStatus();

        $this->expectException(\Sberbank\Exception\InvalidRequestException::class);
        $request->validate();

        /** @var \Sberbank\Message\RestResponse $response */
        $response = $request->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertFalse($response->isSuccessful());
    }
}