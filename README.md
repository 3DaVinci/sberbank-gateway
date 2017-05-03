# Библиотека для подключения  интернет-магазина к платежному шлюзу Сбербанка

## Установка

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Использование

```php

$gateway = \Sberbank\RestGateway([
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