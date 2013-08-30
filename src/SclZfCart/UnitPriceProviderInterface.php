<?php

namespace SclZfCart;

/**
 * Interface for objects which provide unit price values.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface UnitPriceProviderInterface
{
    /**
     * Get the tax amount.
     *
     * @return float
     */
    public function getUnitTax();

    /**
     * Get the price.
     *
     * @return float
     */
    public function getUnitPrice();
}
