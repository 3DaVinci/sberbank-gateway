<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */

namespace Sberbank\Tests\Message;

use PHPUnit\Framework\TestCase;
use Mockery;
use Sberbank\Message\RegisterOrderRequest;

class RegisterOrderRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        $this->request = Mockery::mock('\Sberbank\Message\RegisterOrderRequest')->makePartial();
    }

    public function testOrderNumber()
    {
        $this->assertSame($this->request, $this->request->setOrderNumber('112'));
        $orderNumber = $this->request->getParameter('orderNumber');
        $this->assertEquals('112', $orderNumber);
    }

    public function testAmount()
    {
        $this->assertSame($this->request, $this->request->setAmount(12000));
        $amount = $this->request->getParameter('amount');
        $this->assertEquals(12000, $amount);
    }

    public function testReturnUrl()
    {
        $this->assertSame($this->request, $this->request->setReturnUrl('https://server/applicaton_context/finish.html'));
        $returnUrl = $this->request->getParameter('returnUrl');
        $this->assertEquals('https://server/applicaton_context/finish.html', $returnUrl);
    }

    public function testPageView()
    {
        $this->assertSame($this->request, $this->request->setPageView(RegisterOrderRequest::PAGE_VIEW_MOBILE));
        $pageView = $this->request->getParameter('pageView');
        $this->assertEquals(RegisterOrderRequest::PAGE_VIEW_MOBILE, $pageView);
    }

    public function testValidate()
    {
        $this->expectException(\Sberbank\Exception\InvalidRequestException::class);
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
}
