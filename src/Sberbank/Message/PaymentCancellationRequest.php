<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 30.05.2017
 */

namespace Sberbank\Message;

use Sberbank\Exception\InvalidRequestException;

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
        return 'rest/reverse.do';
    }
}