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
        return $this->data['data']['orderId'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getErrorCode(): ?int
    {
        if (isset($this->data['error']['code'])) {

            return (int) $this->data['error']['code'];
        }

        return null;

    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        if (isset($this->data['error']['message'])) {

            return $this->data['error']['message'];
        }

        return '';
    }
}