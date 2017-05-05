<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 05.05.2017
 */

namespace Sberbank\Tests\Message;

use PHPUnit\Framework\TestCase;
use Sberbank\Entity\Binding;

class BindingTest extends TestCase
{
    public function testConstruct()
    {
        $binding = new Binding([
            'bindingId' => 'e09c8c1d-9d1a-4c39-a9d3-123c6075429c',
            'maskedPan' => '555555**5599',
            'expiryDate' => '201912',
        ]);

        $this->assertEquals('e09c8c1d-9d1a-4c39-a9d3-123c6075429c', $binding->getBindingId());
        $this->assertEquals('555555**5599', $binding->getMaskedPan());
        $this->assertEquals('201912', $binding->getExpiryDate());
    }
}