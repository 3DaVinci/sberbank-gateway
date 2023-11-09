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
    protected string $liveUrl = 'https://securepayments.sberbank.ru/payment/';
    protected string $testUrl = 'https://3dsec.sberbank.ru/payment/';

    /**
     * The request parameters
     *
     * @var array
     */
    protected array $parameters = [];

    /**
     * An associated ResponseInterface.
     *
     * @var ResponseInterface|null
     */
    protected ?ResponseInterface $response = null;

    /**
     * @var string
     */
    protected string $responseClassName;

    /**
     * @var Client
     */
    protected Client $sberbankClient;

    abstract public function getMethodName();

    /**
     * RequestAbstract constructor.
     * @param Client $sberbankClient
     * @param string $responseClassName
     */
    public function __construct(Client $sberbankClient, string $responseClassName = '\Sberbank\Message\RestResponse')
    {
        $this->sberbankClient = $sberbankClient;
        $this->responseClassName = $responseClassName;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return string
     */
    protected function getUrl(): string
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
    public function setPassword(string $value): RequestAbstract
    {
        return $this->setParameter('password', $value);
    }

    /**
     * Логин магазина, полученный при подключении
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setUserName(string $value): RequestAbstract
    {
        return $this->setParameter('userName', $value);
    }

    /**
     * @return boolean
     */
    public function getTestMode(): ?bool
    {
        return $this->getParameter('testMode');
    }

    /**
     * @param bool $value
     * @return RequestAbstract
     */
    public function setTestMode(bool $value): RequestAbstract
    {
        return $this->setParameter('testMode', $value);
    }

    /**
     * Return parameters listed in $keys
     * Return all parameters if $keys empty
     *
     * @param array $keys
     * @return array
     */
    public function getParameters(array $keys = []): array
    {
        if (empty($keys)) {

            return $this->parameters;
        } else {
            $params = [];
            foreach ($keys as $key) {
                $params[$key] = $this->getParameter($key);
            }

            return $params;
        }
    }

    /**
     * Get a single parameter.
     *
     * @param string $key
     * @return mixed
     */
    protected function getParameter(string $key)
    {
        return $this->parameters[$key] ?? null;
    }

    /**
     * Set a single parameter
     *
     * @param string $key
     * @param mixed $value
     * @return RequestAbstract
     */
    protected function setParameter(string $key, $value): RequestAbstract
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
    public function initialize(array $parameters): RequestAbstract
    {
        foreach ($parameters as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    public function send(): ResponseInterface
    {
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