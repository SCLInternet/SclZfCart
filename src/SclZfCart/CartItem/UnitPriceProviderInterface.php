<?php

namespace SclZfCart\CartItem;

use SCL\Currency\TaxedPrice;

interface UnitPriceProviderInterface
{
    /**
     * @return TaxedPrice
     */
    public function getUnitPrice();
}
