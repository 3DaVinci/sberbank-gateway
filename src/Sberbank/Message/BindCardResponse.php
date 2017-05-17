<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 17.05.2017
 */

namespace Sberbank\Message;

class BindCardResponse extends RestResponse
{
    protected $errorMessages = [
        0 => 'Обработка запроса прошла без системных ошибок',
        2 => 'Связка не найдена или имеет неверное состояние',
        5 => 'Доступ запрещен или пользователь должен сменить свой пароль',
        7 => 'Системная ошибка',
    ];
}