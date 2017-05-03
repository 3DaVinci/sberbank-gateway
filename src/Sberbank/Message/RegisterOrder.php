<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 19.04.2017
 */

namespace Sberbank\Message;

class RegisterOrder extends RequestAbstract
{
    /**
     * @param string|int $value
     * @return AbstractRequest
     */
    public function setOrderNumber($value)
    {
        return $this->setParameter('orderNumber', $value);
    }

    /**
     * @param int $value
     * @return AbstractRequest
     */
    public function setAmount(int $value)
    {
        return $this->setParameter('amount', $value);
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setReturnUrl(string $value)
    {
        return $this->setParameter('returnUrl', $value);
    }

    /**
     * @throws \Sberbank\Exception\InvalidRequestException
     */
    public function validate()
    {
        parent::validate('orderNumber', 'amount', 'returnUrl');
    }

    public function send()
    {
        /** @var \Psr\Http\Message\ResponseInterface $httpResponse */
        $httpResponse = $this->sberbankClient->get(
            $this->getUrl() . '?' . http_build_query($this->getParameters()),
            ['Content-type' => 'application/json']
        );

        $body = $httpResponse->getBody(true);
        $jsonToArrayResponse = !empty($body) ? json_decode((string) $body, true) : [];

        return $this->response = new RestResponse($this, $jsonToArrayResponse, $httpResponse->getStatusCode());
    }

    protected function getUrl()
    {
        return parent::getUrl() . 'register.do';
    }
}