<?php

namespace SclZfCart;

/**
 * Interface for objects which can have price values set.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface PriceAwareInterface extends PriceProviderInterface
{
    /**
     * Set the tax amount.
     *
     * @param  float $amount
     * @return void
     */
    public function setTax($amount);

    /**
     * Set the price.
     *
     * @param  float $amount
     * @return void
     */
    public function setPrice($amount);
}
