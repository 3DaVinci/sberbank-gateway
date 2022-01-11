<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */

namespace Sberbank\Message;

/**
 * Class OrderStatusResponse
 * @package Sberbank\Message
 */
class OrderStatusResponse extends RestResponse
{
    protected array $errorMessages = [
        0 => 'Обработка запроса прошла без системных ошибок',
        2 => 'Заказ отклонен по причине ошибки в реквизитах платежа',
        5 => 'Доступ запрещён',
        6 => 'Незарегистрированный OrderId',
        7 => 'Системная ошибка',
    ];

    private array $statuses = [
        0 => 'Заказ зарегистрирован, но не оплачен',
        1 => 'Предавторизованная сумма захолдирована (для двухстадийных платежей)',
        2 => 'Проведена полная авторизация суммы заказа',
        3 => 'Авторизация отменена',
        4 => 'По транзакции была проведена операция возврата',
        5 => 'Инициирована авторизация через ACS банка-эмитента',
        6 => 'Авторизация отклонена',
    ];

    /**
     * @return string
     */
    public function getStatus(): string
    {
        $statusCode = $this->data['OrderStatus'] ?? null;

        return $this->statuses[$statusCode] ?? '';
    }
}