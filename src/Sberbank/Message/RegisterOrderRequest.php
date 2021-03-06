<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 19.04.2017
 */

namespace Sberbank\Message;

/**
 * Class RegisterOrderRequest
 * @package Sberbank\Message
 */
class RegisterOrderRequest extends RequestAbstract
{
    const PAGE_VIEW_DESKTOP = 'DESKTOP';
    const PAGE_VIEW_MOBILE = 'MOBILE';

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
     * По значению данного параметра определяется, какие страницы платёжного интерфейса должны загружаться для клиента.
     * Возможные значения:
     *   DESKTOP – для загрузки страниц, верстка которых предназначена для отображения на экранах ПК;
     *   MOBILE – для загрузки страниц, верстка которых предназначена для отображения на экранах мобильных устройств;
     *   Если магазин создал страницы платёжного интерфейса, добавив в название файлов страниц произвольные префиксы,
     * передайте значение нужного префикса в параметре pageView для загрузки соответствующей страницы. Например,
     * при передаче значения iphone в архиве страниц платёжного интерфейса будет осуществляться поиск страниц с
     * названиями iphone_p ayment_<locale>.html и iphone_error_<locale>.html.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setPageView(string $value)
    {
        return $this->setParameter('pageView', $value);
    }

    /**
     * Продолжительность жизни заказа в секундах.
     * В случае если параметр не задан, будет использовано значение, указанное в настройках мерчанта или время по
     * умолчанию (1200 секунд = 20 минут).
     *
     * @param int $value
     * @return RequestAbstract
     */
    public function setSessionTimeoutSecs(int $value)
    {
        return $this->setParameter('sessionTimeoutSecs', $value);
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
     * Код валюты платежа ISO 4217. Если не указан, считается равным коду валюты по умолчанию.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setCurrency(string $value)
    {
        return $this->setParameter('currency', $value);
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
     * Чтобы зарегистрировать заказ от имени дочернего мерчанта, укажите его логин в этом параметре.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setMerchantLogin(string $value)
    {
        return $this->setParameter('merchantLogin', $value);
    }

    /**
     * Идентификатор связки, созданной ранее. Может использоваться, только если у магазина есть разрешение на работу со связками.
     * Если этот параметр передаётся в данном запросе, то это означает:
     *  1. Данный заказ может быть оплачен только с помощью связки;
     *  2. Плательщик будет перенаправлен на платёжную страницу, где требуется только ввод CVC.
     *
     * @param string $value
     * @return RequestAbstract
     */
    public function setBindingId(string $value)
    {
        return $this->setParameter('bindingId', $value);
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
     * @throws \Sberbank\Exception\InvalidRequestException
     */
    public function validate()
    {
        parent::validate('orderNumber', 'amount', 'returnUrl');
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return 'register.do';
    }
}