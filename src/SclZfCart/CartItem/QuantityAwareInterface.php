<?php

namespace SclZfCart\CartItem;

/**
 * Interface for cart items which can have a quantity value set.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface QuantityAwareInterface extends QuantityProviderInterface
{
    /**
     * Set the quantity of an item.
     *
     * @param  int  $quantity
     * @return void
     */
    public function setQuantity($quantity);
}
