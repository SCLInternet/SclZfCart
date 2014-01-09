<?php

namespace SclZfCart\CartItem;

use SCL\Currency\TaxedPrice;

/**
 * Interface for objects which provide price values.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface PriceProviderInterface
{
    /**
     * @return TaxedPrice
     */
    public function getPrice();
}
