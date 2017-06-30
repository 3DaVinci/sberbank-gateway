# Библиотека для работы с платежным шлюзом Сбербанка. Интерфейс REST.

[![Build Status](https://api.travis-ci.org/3DaVinci/sberbank-gateway.png?branch=master)](https://travis-ci.org/3DaVinci/sberbank-gateway)

## Установка

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Возможности

 - registerOrder - запрос регистрации заказа
 - orderStatus - запрос состояния заказа
 - paymentCancellation - запрос отмены оплаты заказа
 - refund - запрос возврата средств оплаты заказа
 - getBindings - запрос списка связок по идентификатору клиента
 - getBindCard - запрос активации связки
 - getUnbindCard - запрос деактивации связки

## Пример использования

```php
<?php

$gateway = new \Sberbank\RestGateway([
    'password' => 'password',
    'userName' => 'username'
]);

$response = $gateway->registerOrder([
        'orderNumber' => 1,
        'amount' => 12000,
        'returnUrl' => 'https://server/applicaton_context/finish.html'
    ])
    ->send();

if ($response->isSuccessful()) {
    $response->getData();
}
```
