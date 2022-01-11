<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */

namespace Sberbank\Tests\Message;

use PHPUnit\Framework\TestCase;
use Mockery;
use Sberbank\Exception\InvalidRequestException;
use Sberbank\Message\RegisterOrderRequest;

class RegisterOrderRequestTest extends TestCase
{
    private Mockery\MockInterface $request;

    public function setUp(): void
    {
        $this->request = Mockery::mock('\Sberbank\Message\RegisterOrderRequest')->makePartial();
    }

    public function testOrderNumber()
    {
        $this->assertSame($this->request, $this->request->setOrderNumber('112'));
        $result = $this->request->getParameter('orderNumber');
        $this->assertEquals('112', $result);
    }

    public function testAmount()
    {
        $this->assertSame($this->request, $this->request->setAmount(12000));
        $result = $this->request->getParameter('amount');
        $this->assertEquals(12000, $result);
    }

    public function testReturnUrl()
    {
        $this->assertSame($this->request, $this->request->setReturnUrl('https://server/applicaton_context/finish.html'));
        $result = $this->request->getParameter('returnUrl');
        $this->assertEquals('https://server/applicaton_context/finish.html', $result);
    }

    public function testFailUrl()
    {
        $this->assertSame($this->request, $this->request->setFailUrl('https://server/applicaton_context/fail.html'));
        $result = $this->request->getParameter('failUrl');
        $this->assertEquals('https://server/applicaton_context/fail.html', $result);
    }

    public function testPageView()
    {
        $this->assertSame($this->request, $this->request->setPageView(RegisterOrderRequest::PAGE_VIEW_MOBILE));
        $result = $this->request->getParameter('pageView');
        $this->assertEquals(RegisterOrderRequest::PAGE_VIEW_MOBILE, $result);
    }

    public function testClientId()
    {
        $this->assertSame($this->request, $this->request->setClientId('18547'));
        $result = $this->request->getParameter('clientId');
        $this->assertEquals('18547', $result);
    }

    public function testCurrency()
    {
        $this->assertSame($this->request, $this->request->setCurrency('RUS'));
        $result = $this->request->getParameter('currency');
        $this->assertEquals('RUS', $result);
    }

    public function testLanguage()
    {
        $this->assertSame($this->request, $this->request->setLanguage('RU'));
        $result = $this->request->getParameter('language');
        $this->assertEquals('RU', $result);
    }

    public function testMerchantLogin()
    {
        $this->assertSame($this->request, $this->request->setMerchantLogin('login name'));
        $result = $this->request->getParameter('merchantLogin');
        $this->assertEquals('login name', $result);
    }

    public function testBindingId()
    {
        $this->assertSame($this->request, $this->request->setBindingId('e09c8c1d-9d1a-4c39-a9d3-123c6075429c'));
        $result = $this->request->getParameter('bindingId');
        $this->assertEquals('e09c8c1d-9d1a-4c39-a9d3-123c6075429c', $result);
    }

    public function testSessionTimeoutSecs()
    {
        $this->assertSame($this->request, $this->request->setSessionTimeoutSecs(1200));
        $result = $this->request->getParameter('sessionTimeoutSecs');
        $this->assertEquals(1200, $result);
    }

    public function testDescription()
    {
        $this->assertSame($this->request, $this->request->setDescription('Описание заказа'));
        $result = $this->request->getParameter('description');
        $this->assertEquals('Описание заказа', $result);
    }

    public function testValidate()
    {
        $this->expectException(InvalidRequestException::class);
        $this->request
            ->setPassword('123456')
            ->setUserName('user_name');
        $this->request->validate();

        // Not Exception
        $this->request
            ->setOrderNumber('112')
            ->setAmount(12000)
            ->setReturnUrl('https://server/applicaton_context/finish.html');
        $this->request->validate();
    }

    public function testGetMethodName()
    {
        $method = $this->request->getMethodName();
        $this->assertTrue(is_string($method));
        $this->assertNotEmpty($method);
    }

    public function testPhone()
    {
        $this->assertSame($this->request, $this->request->setPhone('+71234567890'));
        $result = $this->request->getParameter('phone');
        $this->assertEquals('+71234567890', $result);
    }

    public function testEmail()
    {
        $this->assertSame($this->request, $this->request->setEmail('test@test.ru'));
        $result = $this->request->getParameter('email');
        $this->assertEquals('test@test.ru', $result);
    }
}
