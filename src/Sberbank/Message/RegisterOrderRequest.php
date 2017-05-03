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
     * @param string|int $value
     * @return RequestAbstract
     */
    public function setOrderNumber($value)
    {
        return $this->setParameter('orderNumber', $value);
    }

    /**
     * @param int $value
     * @return RequestAbstract
     */
    public function setAmount(int $value)
    {
        return $this->setParameter('amount', $value);
    }

    /**
     * @param string $value
     * @return RequestAbstract
     */
    public function setReturnUrl(string $value)
    {
        return $this->setParameter('returnUrl', $value);
    }

    /**
     * @param string $value
     * @return RequestAbstract
     */
    public function setPageView(string $value)
    {
        return $this->setParameter('pageView', $value);
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