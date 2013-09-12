<?php

namespace SclZfCart\CartItem;

/**
 * Interface for objects which provide price values.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface PriceProviderInterface
{
    /**
     * Get the tax amount.
     *
     * @return float
     */
    public function getTax();

    /**
     * Get the price.
     *
     * @return float
     */
    public function getPrice();
}
