<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 02.05.2017
 */

namespace Sberbank\Message;

/**
 * Interface RequestInterface
 * @package Sberbank\Message
 */
interface RequestInterface
{
    /**
     * Initialize request with parameters
     * @param array $parameters The parameters to send
     */
    public function initialize(array $parameters);

    /**
     * Get all request parameters
     *
     * @return array
     */
    public function getParameters(): array;

    /**
     * Get the response to this request (if the request has been sent)
     *
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface;

    /**
     * Send the request
     *
     * @return ResponseInterface
     */
    public function send(): ResponseInterface;
}