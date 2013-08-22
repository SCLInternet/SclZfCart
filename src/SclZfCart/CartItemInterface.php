<?php

namespace SclZfCart;

/**
 * The interface for any item that wants to be added to the cart.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartItemInterface extends ProvidesUidInterface, \Serializable
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
     * Sets the uid.
     *
     * @param  string $uid
     * @return string
     */
    public function setUid($uid);

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
     * Returns the tax amount for a single item.
     *
     * @return float|null NULL can be returned to stop this from being displayed in the cart
     */
    public function getUnitTax();

    /**
     * Get the total tax amount for the set quantity.
     *
     * @return float
     */
    public function getTax();

    /**
     * Returns the price for a single item.
     *
     * @return float|null NULL can be returned to stop this from being displayed in the cart
     */
    public function getUnitPrice();

    /**
     * Returns the price the set quantity.
     *
     * @return float
     */
    public function getPrice();
}
