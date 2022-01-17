<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 19.04.2017
 */

namespace Sberbank\Message;

/**
 * Interface ResponseInterface
 * @package Sberbank\Message
 */
interface ResponseInterface
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful(): bool;

    /**
     * Does the response require a redirect?
     *
     * @return mixed
     */
    public function getData();

    /**
     * @return RequestInterface|null
     */
    public function getRequest(): ?RequestInterface;

    /**
     * Response code
     *
     * @return null|string A response code from Sberbank gateway
     */
    public function getCode(): ?string;

    /**
     * Sberbank error code
     *
     * @return int|null
     */
    public function getErrorCode(): ?int;

    /**
     * Sberbank error message
     *
     * @return string
     */
    public function getErrorMessage(): string;

    /**
     * Sberbank error message by code
     *
     * @return string
     */
    public function getErrorMessageByCode(): string;
}