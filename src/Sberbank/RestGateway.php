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
    private $parameters;

    /**
     * RestGateway constructor.
     * @param array $parameters
     * @param HttpClient|null $client
     */
    public function __construct(array $parameters, $client = null)
    {
        $this->httpClient = $client ?: new Client();
        $this->parameters = array_replace($this->getDefaultParameters(), $parameters);
    }

    /**
     * @param array $parameters
     * @return RequestAbstract
     */
    public function registerOrder(array $parameters = [])
    {
        return $this->createRequest('\Sberbank\Message\RegisterOrder', $parameters);
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
     * @param string $class
     * @param array $parameters
     * @return RequestAbstract
     */
    private function createRequest(string $class, array $parameters) : RequestAbstract
    {
        $requestObj = new $class($this->httpClient);

        return $requestObj->initialize(array_replace($this->getParameters(), $parameters));
    }
}