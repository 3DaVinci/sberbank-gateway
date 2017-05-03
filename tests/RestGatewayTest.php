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
            $this->setMockSberbankClient(['RegisterOrderSuccess', 'RegisterOrderError'])
        );
    }

    public function testRegisterOrderSuccess()
    {
        /** @var \Sberbank\Message\RegisterOrder $registerOrderRequest */
        $registerOrderRequest = $this->gateway->registerOrder([
            'orderNumber' => 1,
            'amount' => 12000,
            'returnUrl' => 'https://server/applicaton_context/finish.html'
        ]);

        $registerOrderRequest->validate();

        /** @var \Sberbank\Message\RestResponse $response */
        $response = $registerOrderRequest->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertTrue($response->isSuccessful());
    }

    public function testRegisterOrderError()
    {
        /** @var \Sberbank\Message\RegisterOrder $registerOrderRequest */
        $registerOrderRequest = $this->gateway->registerOrder([
            'orderNumber' => 1,
            'returnUrl' => 'https://server/applicaton_context/finish.html'
        ]);

        $this->expectException(\Sberbank\Exception\InvalidRequestException::class);
        $registerOrderRequest->validate();

        /** @var \Sberbank\Message\RestResponse $response */
        $response = $registerOrderRequest->send();

        $this->assertInstanceOf('\Sberbank\Message\RestResponse', $response);
        $this->assertNotEmpty($response->getData());
        $this->assertFalse($response->isSuccessful());
    }
}