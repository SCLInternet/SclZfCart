<?php

namespace SclZfCart\CartItem;

use SCL\Currency\TaxedPrice;

interface PriceAwareInterface extends PriceProviderInterface
{
    public function setPrice(TaxedPrice $price);
}
