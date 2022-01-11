<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */

namespace Sberbank\Tests\Message;

use PHPUnit\Framework\TestCase;
use Mockery;

class ClientTest extends TestCase
{
    public function testConstruct()
    {
        $client = Mockery::mock('\Sberbank\Http\Client')->makePartial();
        $client->__construct();
        $this->assertInstanceOf('\Http\Client\HttpClient', $client->getHttpClient());
        $this->assertInstanceOf('\Http\Message\RequestFactory', $client->getRequestFactory());
    }
}