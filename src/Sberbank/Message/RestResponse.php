<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 02.05.2017
 */

namespace Sberbank\Message;

/**
 * Class RestResponse
 * @package Sberbank\Message
 */
class RestResponse implements ResponseInterface
{
    /**
     * The embodied request object.
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * The data contained in the response.
     *
     * @var mixed
     */
    protected $data;

    /**
     * @var int
     */
    protected $statusCode;

    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        $this->request = $request;
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        $code = $this->getCode();
        return (!isset($this->data['errorCode']) || $this->data['errorCode'] == 0)
        && $code && $code < 400;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the response data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->statusCode;
    }

    /**
     * @return int|null
     */
    public function getErrorCode()
    {
        return isset($this->data['errorCode']) ? (int) $this->data['errorCode'] : null;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return '';
    }
}