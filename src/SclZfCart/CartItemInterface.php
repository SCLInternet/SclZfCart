<?php

namespace SclZfCart;

/**
 * The interface for any item that wants to be added to the cart.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartItemInterface
{
    /**
     * Return the main title of the product to be displayed it the cart.
     *
     * @return string
     */
    public function getTitle();

    /**
     * An extended description for the product.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Returns a unique identifier for this product.
     *
     * @return string
     */
    public function getUid();

    /**
     * Sets the quantity for this item.
     *
     * @param int $quantity
     */
    public function setQuantity($quantity);

    /**
     * Returns the quantity.
     *
     * @return int
     */
    public function getQuantity();

    /**
     * Returns the price for this item
     *
     * @return float
     */
    public function getPrice();
}
