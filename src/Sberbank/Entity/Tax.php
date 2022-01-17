<?php

namespace Sberbank\Entity;

class Tax extends AbstractEntity
{
    /**
     * 0 – без НДС;
     * 1 – НДС по ставке 0%;
     * 2 – НДС чека по ставке 10%;
     * 4 – НДС чека по расчетной ставке 10/110;
     * 6 - НДС чека по ставке 20%;
     * 7 - НДС чека по расчётной ставке 20/120.
     */
    const WITHOUT_VAT = 0;
    const VAT_0       = 1;
    const VAT_10      = 2;
    const VAT_10_110  = 4;
    const VAT_20      = 6;
    const VAT_20_120  = 7;

    protected int $taxType;

    protected int $taxSum;

    public function __construct(int $amount = 0, $taxType = self::VAT_20)
    {
        $this->setTaxType($taxType);
        switch ($taxType) {
            case self::VAT_10:
            case self::VAT_10_110:
                $this->setTaxSum((int) ($amount/110)*10);
                break;
            case self::VAT_20:
            case self::VAT_20_120:
                $this->setTaxSum((int) ($amount/120)*20);
                break;
            default:
                $this->setTaxSum(0);
        }
    }

    /**
     * @return int
     */
    public function getTaxType(): int
    {
        return $this->taxType;
    }

    /**
     * @param int $taxType
     * @return Tax
     */
    public function setTaxType(int $taxType): Tax
    {
        $this->taxType = $taxType;
        return $this;
    }

    /**
     * @return int
     */
    public function getTaxSum(): int
    {
        return $this->taxSum;
    }

    /**
     * @param int $taxSum
     * @return Tax
     */
    public function setTaxSum(int $taxSum): Tax
    {
        $this->taxSum = $taxSum;
        return $this;
    }
}