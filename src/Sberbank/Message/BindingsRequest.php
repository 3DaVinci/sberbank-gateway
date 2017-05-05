<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 05.05.2017
 */

namespace Sberbank\Message;

/**
 * Class BindingsRequest
 * @package Sberbank\Message
 */
class BindingsRequest extends RequestAbstract
{
    /**
     * Номер (идентификатор) клиента в системе магазина, переданный при регистрации заказа. Присутствует только если
     * магазину разрешено создание связок.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setClientId(string $value)
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * @throws \Sberbank\Exception\InvalidRequestException
     */
    public function validate()
    {
        parent::validate('clientId');
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return 'getBindings.do';
    }
}