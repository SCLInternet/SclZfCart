<?php

namespace SclZfCart\CartItem;

use SCL\Currency\TaxedPrice;

trait UnitPriceAwareTrait
{
    /**
     * @var TaxedPrice
     */
    private $unitPrice;

    /**
     * @return TaxedPrice
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(TaxedPrice $unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }
}
