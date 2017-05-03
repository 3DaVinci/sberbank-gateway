<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */

namespace Sberbank\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Sberbank\Exception\InvalidRequestException;

class InvalidRequestExceptionTest extends TestCase
{
    public function testConstruct()
    {
        $exception = new InvalidRequestException('Error');
        $this->assertSame('Error', $exception->getMessage());
    }
}