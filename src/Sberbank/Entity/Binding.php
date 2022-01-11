<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 05.05.2017
 */

namespace Sberbank\Entity;

/**
 * Class Binding
 * @package Sberbank\Entity
 */
class Binding
{
    /**
     * Идентификатор связки созданной при оплате заказа или использованной для оплаты. Присутствует только если
     * магазину разрешено создание связок.
     *
     * @var string
     */
    private $bindingId;

    /**
     * Маскированный номер карты, которая использовалась для оплаты. Указан только после оплаты заказа.
     *
     * @var string
     */
    private $maskedPan;

    /**
     * Срок истечения действия карты в формате YYYYMM. Указан только после оплаты заказа.
     *
     * @var string
     */
    private $expiryDate;

    public function __construct(array $parameters = [])
    {
        $this->bindingId = $parameters['bindingId'];
        $this->maskedPan = $parameters['maskedPan'];
        $this->expiryDate = $parameters['expiryDate'];
    }

    /**
     * @return string
     */
    public function getBindingId(): string
    {
        return $this->bindingId;
    }

    /**
     * @return string
     */
    public function getMaskedPan(): string
    {
        return $this->maskedPan;
    }

    /**
     * @return string
     */
    public function getExpiryDate(): string
    {
        return $this->expiryDate;
    }

    public function __toString()
    {
        return $this->maskedPan;
    }
}