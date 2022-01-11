<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 17.05.2017
 */

namespace Sberbank\Message;

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
    public function setBindingId(string $value)
    {
        return $this->setParameter('bindingId', $value);
    }

    /**
     * @throws \Sberbank\Exception\InvalidRequestException
     */
    public function validate()
    {
        parent::validate('bindingId');
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return 'rest/bindCard.do';
    }
}