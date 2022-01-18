<?php /** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpDocMissingThrowsInspection */

/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 18.04.2017
 */

namespace Sberbank\Http;

use Http\Client\Exception;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Client implements HttpClient, RequestFactory
{
    /**
     * @var HttpClient
     */
    private HttpClient $httpClient;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->requestFactory = MessageFactoryDiscovery::find();
    }

    /**
     * @param $method
     * @param $uri
     * @param array $headers
     * @param string|resource|StreamInterface|null $body
     * @param string $protocolVersion
     * @return RequestInterface
     */
    public function createRequest($method, $uri, array $headers = [], $body = null, $protocolVersion = '1.1'): RequestInterface
    {
        return $this->requestFactory->createRequest($method, $uri, $headers, $body, $protocolVersion);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Exception
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Send a GET request.
     *
     * @param UriInterface|string $uri
     * @param array $headers
     * @return ResponseInterface
     */
    public function get($uri, array $headers = []): ResponseInterface
    {
        $request = $this->createRequest('GET', $uri, $headers);

        return $this->sendRequest($request);
    }

    /**
     * Send a POST request.
     *
     * @param UriInterface|string $uri
     * @param array $headers
     * @param null $body
     * @return ResponseInterface
     * @throws Exception
     */
    public function post($uri, array $headers = [], $body = null): ResponseInterface
    {
        $request = $this->createRequest('POST', $uri, $headers, $body);

        return $this->sendRequest($request);
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @return RequestFactory
     */
    public function getRequestFactory()
    {
        return $this->requestFactory;
    }


}