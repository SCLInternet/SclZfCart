<?php

namespace SclZfCart;

/**
 * Interface for objects which can have unit price values set.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface UnitPriceAwareInterface extends UnitPriceProviderInterface
{
    /**
     * Set the tax amount.
     *
     * @param  float $amount
     * @return void
     */
    public function setUnitTax($amount);

    /**
     * Set the price.
     *
     * @param  float $amount
     * @return void
     */
    public function setUnitPrice($amount);
}
