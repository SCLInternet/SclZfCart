<?php

namespace SclZfCart;

use SclZfCart\CartItem\PriceProviderInterface;
use SclZfCart\CartItem\UidProviderInterface;
use SclZfCart\CartItem\UnitPriceProviderInterface;
use SclZfCart\CartItem\QuantityProviderInterface;

/**
 * The interface for any item that wants to be added to the cart.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartItemInterface extends
    PriceProviderInterface,
    QuantityProviderInterface,
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
}
