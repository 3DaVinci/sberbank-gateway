<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */


namespace Sberbank\Message;

/**
 * Class OrderStatusRequest
 * @package Sberbank\Message
 */
class OrderStatusRequest extends RequestAbstract
{
    /**
     * @param string|int $value
     * @return AbstractRequest
     */
    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    /**
     * @throws \Sberbank\Exception\InvalidRequestException
     */
    public function validate()
    {
        parent::validate('orderId');
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return 'getOrderStatus.do';
    }
}