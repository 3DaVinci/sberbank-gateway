<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 30.05.2017
 */

namespace Sberbank\Message;

use Sberbank\Exception\InvalidRequestException;

class RefundRequest extends RequestAbstract
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
     * Сумма платежа в копейках (или центах)
     *
     * @param int $value
     * @return RequestAbstract
     */
    public function setAmount(int $value): RequestAbstract
    {
        return $this->setParameter('amount', $value);
    }

    /**
     * @throws InvalidRequestException
     */
    public function validate()
    {
        parent::validate('orderId', 'amount');
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return 'rest/refund.do';
    }
}