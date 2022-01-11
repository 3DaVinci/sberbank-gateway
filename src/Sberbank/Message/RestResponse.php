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
     * @var RequestInterface|null
     */
    protected ?RequestInterface $request = null;

    /**
     * The data contained in the response.
     *
     * @var mixed
     */
    protected $data;

    /**
     * @var string|null
     */
    protected ?string $statusCode = null;

    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        $this->request = $request;
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        $code = $this->getCode();
        $errorCode = $this->getErrorCode();

        return (!$errorCode || $errorCode == 0) && $code && $code < 400;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): ?RequestInterface
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
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->statusCode;
    }

    /**
     * @return int|null
     */
    public function getErrorCode(): ?int
    {
        if (isset($this->data['errorCode'])) {

            return (int) $this->data['errorCode'];
        }
        if (isset($this->data['ErrorCode'])) {

            return (int) $this->data['ErrorCode'];
        }

        return null;

    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        if (isset($this->data['errorMessage'])) {

            return $this->data['errorMessage'];
        }
        if (isset($this->data['ErrorMessage'])) {

            return $this->data['ErrorMessage'];
        }

        return '';
    }

    /**
     * @return string
     */
    public function getErrorMessageByCode(): string
    {
        if (isset($this->errorMessages)) {
            $code = $this->getErrorCode();

            return $this->errorMessages[$code] ?? '';
        }

        return '';
    }
}