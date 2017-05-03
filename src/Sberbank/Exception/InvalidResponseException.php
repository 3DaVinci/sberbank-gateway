<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 19.04.2017
 */

namespace Sberbank\Exception;

class InvalidResponseException extends \Exception
{
    public function __construct($message = 'Invalid response from Sberbank gateway', $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}