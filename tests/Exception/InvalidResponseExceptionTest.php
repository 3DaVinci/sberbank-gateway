<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 03.05.2017
 */

namespace Sberbank\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Sberbank\Exception\InvalidResponseException;

class InvalidResponseExceptionTest extends TestCase
{
    public function testConstruct()
    {
        $exception = new InvalidResponseException('Error');
        $this->assertSame('Error', $exception->getMessage());
    }
}