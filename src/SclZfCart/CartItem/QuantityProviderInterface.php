<?php

namespace SclZfCart\CartItem;

/**
 * Interface for cart items which contain a quantity.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface QuantityProviderInterface
{
    /**
     * Return the quantity of items.
     *
     * @return int
     */
    public function getQuantity();
}
