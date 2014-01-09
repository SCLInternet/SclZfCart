<?php

namespace SclZfCart;

use SclZfCart\CartItem\PriceProviderInterface;
use SclZfCart\CartItem\QuantityProviderInterface;
use SclZfCart\CartItem\TitleProviderInterface;
use SclZfCart\CartItem\UidProviderInterface;
use SclZfCart\CartItem\UnitPriceProviderInterface;

/**
 * The interface for any item that wants to be added to the cart.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartItemInterface extends
    PriceProviderInterface,
    QuantityProviderInterface,
    TitleProviderInterface,
    UidProviderInterface,
    UnitPriceProviderInterface
{
}
