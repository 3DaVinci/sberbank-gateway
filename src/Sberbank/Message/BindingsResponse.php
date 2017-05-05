<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 05.05.2017
 */

namespace Sberbank\Message;

use Sberbank\Entity\Binding;

/**
 * Class BindingsResponse
 * @package Sberbank\Message
 */
class BindingsResponse extends RestResponse
{
    /**
     * @var array
     */
    private $bindingsCache;

    /**
     * Не используется, т.к. в ответе есть поле errorMessage
     * @var array
     */
    protected $errorMessages = [
        0 => 'Обработка запроса прошла без системных ошибок',
        1 => '[clientId] не задан',
        2 => 'Информация не найдена',
        5 => 'Доступ запрещен или пользователь должен сменить свой пароль',
        7 => 'Системная ошибка',
    ];

    /**
     * @return Binding[]|array
     */
    public function getBindings()
    {
        if ($this->bindingsCache) {

            return $this->bindingsCache;
        }

        $bindings = [];
        if (!empty($this->data['bindings'])) {
            foreach ($this->data['bindings'] as $bindingParams) {
                $bindings[] = new Binding($bindingParams);
            }
        }

        return $this->bindingsCache = $bindings;
    }
}