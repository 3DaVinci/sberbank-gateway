<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 17.05.2017
 */

namespace Sberbank\Message;

use Sberbank\Exception\InvalidRequestException;

/**
 * Class BindCardRequest
 * @package Sberbank\Message
 */
class BindCardRequest extends RequestAbstract
{
    /**
     * Идентификатор связки, созданной ранее.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setBindingId(string $value): RequestAbstract
    {
        return $this->setParameter('bindingId', $value);
    }

    /**
     * @throws InvalidRequestException
     */
    public function validate()
    {
        parent::validate('bindingId');
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return 'rest/bindCard.do';
    }
}