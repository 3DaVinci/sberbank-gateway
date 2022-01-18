<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 02.05.2017
 */

namespace Sberbank;

use Http\Client\HttpClient;
use Sberbank\Http\Client;
use Sberbank\Message\RequestAbstract;

class RestGateway implements GatewayInterface
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var array
     */
    private array $parameters;

    /**
     * RestGateway constructor.
     * @param array $parameters
     * @param HttpClient|null $client
     */
    public function __construct(array $parameters, HttpClient $client = null)
    {
        $this->httpClient = $client ?: new Client();
        $this->parameters = array_replace($this->getDefaultParameters(), $parameters);
    }

    /**
     * Запрос состояния заказа
     *
     * @param array $parameters
     * @return RequestAbstract
     */
    public function orderStatus(array $parameters = []): RequestAbstract
    {
        return $this->createRequest('OrderStatus', $parameters);
    }

    /**
     * Запрос регистрации заказа
     *
     * @param array $parameters
     * @return RequestAbstract
     */
    public function registerOrder(array $parameters = []): RequestAbstract
    {
        return $this->createRequest('RegisterOrder', $parameters);
    }

    /**
     * Запрос оплаты заказа через GooglePay
     *
     * @param array $parameters
     * @return RequestAbstract
     */
    public function googlePayment(array $parameters = [])
    {
        return $this->createRequest('GooglePayment', $parameters);
    }

    /**
     * Запрос отмены оплаты заказа
     *
     * @param array $parameters
     * @return RequestAbstract
     */
    public function paymentCancellation(array $parameters = []): RequestAbstract
    {
        return $this->createRequest('PaymentCancellation', $parameters);
    }

    /**
     * Запрос возврата средств оплаты заказа
     *
     * @param array $parameters
     * @return RequestAbstract
     */
    public function refund(array $parameters = []): RequestAbstract
    {
        return $this->createRequest('Refund', $parameters);
    }

    /**
     * Запрос списка связок по идентификатору клиента
     *
     * @param string $clientId
     * @return RequestAbstract
     */
    public function getBindings(string $clientId): RequestAbstract
    {
        return $this->createRequest('Bindings', ['clientId' => $clientId]);
    }

    /**
     * Запрос активации связки
     *
     * @param string $bindingId
     * @return RequestAbstract
     */
    public function getBindCard(string $bindingId): RequestAbstract
    {
        return $this->createRequest('BindCard', ['bindingId' => $bindingId]);
    }

    /**
     * Запрос деактивации связки
     *
     * @param string $bindingId
     * @return RequestAbstract
     */
    public function getUnbindCard(string $bindingId): RequestAbstract
    {
        return $this->createRequest('UnbindCard', ['bindingId' => $bindingId]);
    }

    /**
     * @return array
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }

    /**
     * @return array
     */
    public function getDefaultParameters() : array
    {
        return [
            'password' => '',
            'userName' => '',
            'testMode' => false,
        ];
    }

    /**
     * @param string $classNmae
     * @param array $parameters
     * @return RequestAbstract
     */
    private function createRequest(string $classNmae, array $parameters) : RequestAbstract
    {
        $classRequest = '\Sberbank\Message\\'.$classNmae.'Request';
        $classResponse = '\Sberbank\Message\\'.$classNmae.'Response';
        /** @var RequestAbstract $requestObj */
        $requestObj = new $classRequest($this->httpClient, $classResponse);

        return $requestObj->initialize(array_replace($this->getParameters(), $parameters));
    }
}