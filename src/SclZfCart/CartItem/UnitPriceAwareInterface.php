<?php

namespace SclZfCart\CartItem;

use SCL\Currency\TaxedPrice;

interface UnitPriceAwareInterface extends UnitPriceProviderInterface
{
    public function setUnitPrice(TaxedPrice $amount);
}
