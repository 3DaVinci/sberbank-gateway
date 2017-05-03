<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */

namespace Sberbank\Message;

/**
 * Class RegisterOrderResponse
 * @package Sberbank\Message
 */
class RegisterOrderResponse extends RestResponse
{
    private $errorMessages = [
        0 => 'Обработка запроса прошла без системных ошибок',
        1 => 'Заказ с таким номером уже зарегистрирован в системе',
        3 => 'Неизвестная (запрещенная) валюта',
        4 => 'Отсутствует обязательный параметр запроса',
        5 => 'Ошибка значение параметра запроса',
        7 => 'Системная ошибка',
    ];

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        $code = $this->getErrorCode();

        return $this->errorMessages[$code] ?? '';
    }
}