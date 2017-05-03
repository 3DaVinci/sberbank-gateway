<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */

namespace Sberbank\Tests\Message;

use PHPUnit\Framework\TestCase;
use Mockery;

class RegisterOrderTest extends TestCase
{
    private $request;

    public function setUp()
    {
        $this->request = Mockery::mock('\Sberbank\Message\RegisterOrder')->makePartial();
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

    public function testValidate()
    {
        $this->expectException(\Sberbank\Exception\InvalidRequestException::class);
        $this->request->validate();

        $this->request
            ->setPassword('123456')
            ->setUserName('user_name')
            ->setOrderNumber('112')
            ->setAmount(12000)
            ->setReturnUrl('https://server/applicaton_context/finish.html');
        $this->request->validate();
    }
}
