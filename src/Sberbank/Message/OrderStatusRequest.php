<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */

namespace Sberbank\Message;

use Sberbank\Exception\InvalidRequestException;

/**
 * Class OrderStatusRequest
 * @package Sberbank\Message
 */
class OrderStatusRequest extends RequestAbstract
{
    /**
     * @param string $value
     * @return RequestAbstract
     */
    public function setOrderId(string $value): RequestAbstract
    {
        return $this->setParameter('orderId', $value);
    }

    /**
     * @throws InvalidRequestException
     */
    public function validate()
    {
        parent::validate('orderId');
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return 'rest/getOrderStatus.do';
    }
}