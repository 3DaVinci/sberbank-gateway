<?php

namespace Sberbank\Message;

class GooglePaymentRequest extends RequestAbstract
{
    /**
     * Логин продавца в платёжном шлюзе.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setMerchant(string $value)
    {
        return $this->setParameter('merchant', $value);
    }

    /**
     * Номер (идентификатор) заказа в системе магазина, уникален для каждого магазина в пределах системы
     *
     * @param string|int $value
     * @return RequestAbstract
     */
    public function setOrderNumber($value)
    {
        return $this->setParameter('orderNumber', $value);
    }

    /**
     * Номер (идентификатор) заказа в системе магазина, уникален для каждого магазина в пределах системы
     *
     * @param string|int $value
     * @return RequestAbstract
     */
    public function setProtocolVersion($value)
    {
        return $this->setParameter('protocolVersion', $value);
    }


    /**
     * Описание заказа в свободной форме
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setDescription(string $value)
    {
        return $this->setParameter('description', mb_substr($value, 0, 512));
    }

    /**
     * Код валюты платежа ISO 4217. Если не указан, считается равным коду валюты по умолчанию.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setCurrencyCode(string $value)
    {
        return $this->setParameter('currencyCode', $value);
    }

    /**
     * Язык в кодировке ISO 639-1. Если не указан, будет использован язык, указанный в настройках магазина как язык по умолчанию (default language).
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setLanguage(string $value)
    {
        return $this->setParameter('language', $value);
    }

    /**
     * Номер (идентификатор) клиента в системе магазина. Используется для реализации функционала связок.
     * Может присутствовать, если магазину разрешено создание связок.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setClientId(string $value)
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * Сумма платежа в копейках (или центах)
     *
     * @param int $value
     * @return RequestAbstract
     */
    public function setAmount(int $value)
    {
        return $this->setParameter('amount', $value);
    }

    /**
     * Адрес, на который требуется перенаправить пользователя в случае успешной оплаты. Адрес должен быть указан полностью,
     * включая используемый протокол (например, https://test.ru вместо tes t.ru). В противном случае пользователь будет
     * перенаправлен по адресу следующего вида: http://<ад рес_платёжного_шлюза>/<адрес_продавца>.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setReturnUrl(string $value)
    {
        return $this->setParameter('returnUrl', $value);
    }

    /**
     * Адрес, на который требуется перенаправить пользователя в случае неуспешной оплаты. Адрес должен быть указан полностью,
     * включая используемый протокол (например, https://test.ru вместо tes t.ru). В противном случае пользователь будет
     * перенаправлен по адресу следующего вида: http://<ад рес_платёжного_шлюза>/<адрес_продавца>.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setFailUrl(string $value)
    {
        return $this->setParameter('failUrl', $value);
    }

    /**
     * Номер телефона клиента. Может быть следующего формата: ^((+7|7|8)?([0-9]){10})$.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setPhone(string $value)
    {
        return $this->setParameter('phone', $value);
    }

    /**
     * Адрес электронной почты покупателя.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setEmail(string $value)
    {
        return $this->setParameter('email', $value);
    }

    /**
     * Токен, полученный от Google Pay и закодированный в Base64.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setPaymentToken(string $value)
    {
        return $this->setParameter('paymentToken', $value);
    }

    /**
     * @throws \Sberbank\Exception\InvalidRequestException
     */
    public function validate()
    {
        parent::validate('merchant', 'orderNumber', 'paymentToken', 'amount');
    }

    public function getMethodName()
    {
        return 'google/payment.do';
    }

    public function send()
    {
        /** @var \Psr\Http\Message\ResponseInterface $httpResponse */
        $httpResponse = $this->sberbankClient->get(
            $this->getUrl() . '?' . http_build_query($this->getParameters()),
            ['Content-type' => 'application/json']
        );

        $body = $httpResponse->getBody();
        $jsonToArrayResponse = !empty($body) ? json_decode((string) $body, true) : [];
        $responseClassName = $this->responseClassName;

        return $this->response = new $responseClassName($this, $jsonToArrayResponse, $httpResponse->getStatusCode());
    }
}