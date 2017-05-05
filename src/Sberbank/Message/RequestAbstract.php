<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 18.04.2017
 */

namespace Sberbank\Message;

use Sberbank\Http\Client;
use Sberbank\Exception\InvalidRequestException;
use Sberbank\Exception\RuntimeException;

/**
 * Class RequestAbstract
 * @package Sberbank\Message
 */
abstract class RequestAbstract implements RequestInterface
{
    protected $liveUrl = 'http://62.76.205.3/payment/rest/';
    protected $testUrl = 'https://3dsec.sberbank.ru/payment/rest/';

    /**
     * The request parameters
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * An associated ResponseInterface.
     *
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var string
     */
    protected $responseClassName;

    /**
     * @var Client
     */
    protected $sberbankClient;

    abstract public function getMethodName();

    /**
     * RequestAbstract constructor.
     * @param $sberbankClient
     * @param string $responseClassName
     */
    public function __construct(Client $sberbankClient, $responseClassName = '\Sberbank\Message\RestResponse')
    {
        $this->sberbankClient = $sberbankClient;
        $this->responseClassName = $responseClassName;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    protected function getUrl()
    {
        $url = (false === $this->getTestMode()) ? $this->liveUrl : $this->testUrl;

        return $url . $this->getMethodName();
    }

    /**
     * Пароль магазина, полученный при подключении
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setPassword(string $value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * Логин магазина, полученный при подключении
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setUserName(string $value)
    {
        return $this->setParameter('userName', $value);
    }

    /**
     * @return boolean
     */
    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }

    /**
     * @param bool $value
     * @return RequestAbstract
     */
    public function setTestMode(bool $value)
    {
        return $this->setParameter('testMode', $value);
    }

    /**
     * Get all parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Get a single parameter.
     *
     * @param string $key
     * @return mixed
     */
    protected function getParameter(string $key)
    {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
    }

    /**
     * Set a single parameter
     *
     * @param string $key
     * @param mixed $value
     * @return RequestAbstract
     */
    protected function setParameter(string $key, $value)
    {
        if (null !== $this->response) {
            throw new RuntimeException('Request cannot be modified after it has been sent!');
        }
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * Validate the request.
     *
     * @throws InvalidRequestException
     */
    protected function validate()
    {
        $parameters = array_merge(func_get_args(), ['password', 'userName']);
        foreach ($parameters as $key) {
            if (! isset($this->parameters[$key]) || empty($this->parameters[$key])) {
                throw new InvalidRequestException("The $key parameter is required");
            }
        }
    }

    /**
     * Initialize an request with a given array of parameters
     *
     * @param array $parameters
     * @return RequestAbstract
     */
    public function initialize(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    public function send()
    {
        /** @var \Psr\Http\Message\ResponseInterface $httpResponse */
        $httpResponse = $this->sberbankClient->get(
            $this->getUrl() . '?' . http_build_query($this->getParameters()),
            ['Content-type' => 'application/json']
        );

        $body = $httpResponse->getBody();
        $jsonToArrayResponse = !empty($body) ? json_decode((string) $body, true) : [];
        $responseClassName = $this->responseClassName;

        return $this->response = new $responseClassName($this, $jsonToArrayResponse, $httpResponse->getStatusCode());
    }
}