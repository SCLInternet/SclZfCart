<?php

namespace SclZfCart\CartItem;

/**
 * Basic implementations for a quantity aware cart item.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
trait QuantityAwareTrait
{
    /**
     * The quantity.
     *
     * @var int
     */
    protected $quantity = 1;

    /**
     * Set the quantity of an item.
     *
     * @param  int  $quantity
     * @return void
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    /**
     * Return the quantity of items.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
