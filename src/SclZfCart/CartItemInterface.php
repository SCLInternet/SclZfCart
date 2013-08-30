<?php

namespace SclZfCart;

use SclZfCart\PriceProviderInterface;
use SclZfCart\UidProviderInterface;
use SclZfCart\UnitPriceProviderInterface;
use Serializable;

/**
 * The interface for any item that wants to be added to the cart.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartItemInterface extends
    PriceProviderInterface,
    Serializable,
    UidProviderInterface,
    UnitPriceProviderInterface
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
}
