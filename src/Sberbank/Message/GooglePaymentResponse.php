<?php

namespace Sberbank\Message;

class GooglePaymentResponse extends RestResponse
{
    protected array $errorMessages = [
        0 => 'Обработка запроса прошла без системных ошибок',
        1 => 'Недостаточно средств на карте',
        5 => 'Доступ запрещён.',
        7 => 'Системная ошибка',
        10 => 'Некорректное значение параметра'
    ];

    /**
     * @return string|null
     */
    public function getOrderId(): ?string
    {
        return $this->data['orderId'] ?? null;
    }
}