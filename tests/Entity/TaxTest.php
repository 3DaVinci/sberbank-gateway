<?php

namespace Entity;

use Sberbank\Entity\Tax;
use PHPUnit\Framework\TestCase;

class TaxTest extends TestCase
{
    public function testConstruct()
    {
        $tax = new Tax(120, Tax::VAT_20);
        $this->assertEquals(Tax::VAT_20, $tax->getTaxType());
        $this->assertEquals(20, $tax->getTaxSum());
    }

    public function testGetTaxSum()
    {
        $tax = new Tax();
        $this->assertEquals(0, $tax->getTaxSum());
        $tax->setTaxSum(10);
        $this->assertEquals(10, $tax->getTaxSum());
    }

    public function testGetTaxType()
    {
        $tax = new Tax();
        $this->assertEquals(Tax::VAT_20, $tax->getTaxType());
        $tax->setTaxType(Tax::VAT_10);
        $this->assertEquals(Tax::VAT_10, $tax->getTaxType());
    }
}
