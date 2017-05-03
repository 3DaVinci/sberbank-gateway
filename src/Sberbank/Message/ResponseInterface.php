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
    public function isSuccessful();

    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function getData();

    /**
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * Response code
     *
     * @return null|string A response code from Sberbank gateway
     */
    public function getCode();

    /**
     * Sberbank error code
     *
     * @return int|null
     */
    public function getErrorCode();

    /**
     * Sberbank error message
     *
     * @return string
     */
    public function getErrorMessage();
}