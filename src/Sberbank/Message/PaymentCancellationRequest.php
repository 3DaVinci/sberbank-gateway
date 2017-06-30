<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 30.05.2017
 */

namespace Sberbank\Message;

/**
 * Class PaymentCancellationRequest
 * @package Sberbank\Message
 */
class PaymentCancellationRequest extends RequestAbstract
{
    /**
     * Номер заказа в платежной системе. Уникален в пределах системы.
     *
     * @param string $value
     * @return RequestAbstract
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
        return 'reverse.do';
    }
}