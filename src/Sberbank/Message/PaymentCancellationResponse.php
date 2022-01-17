<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 30.05.2017
 */

namespace Sberbank\Message;

/**
 * Class PaymentCancellationResponse
 * @package Sberbank\Message
 */
class PaymentCancellationResponse extends RestResponse
{
    protected array $errorMessages = [
        0 => 'Обработка запроса прошла без системных ошибок',
        5 => 'Ошибка значение параметра запроса',
        6 => 'Незарегистрированный OrderId',
        7 => 'Системная ошибка',
    ];
}