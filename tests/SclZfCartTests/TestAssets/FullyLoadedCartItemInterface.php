<?php

namespace SclZfCartTests\TestAssets;

use SclZfCart\CartItemInterface;
use SclZfCart\CartItem\DataAwareInterface;
use SclZfCart\CartItem\PriceAwareInterface;
use SclZfCart\CartItem\QuantityAwareInterface;
use SclZfCart\CartItem\TitleAwareInterface;
use SclZfCart\CartItem\UidAwareInterface;
use SclZfCart\CartItem\UnitPriceAwareInterface;

/**
 * Interface which can be mocked which accepts values for all
 * setter traits.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface FullyLoadedCartItemInterface extends
    CartItemInterface,
    DataAwareInterface,
    PriceAwareInterface,
    QuantityAwareInterface,
    TitleAwareInterface,
    UidAwareInterface,
    UnitPriceAwareInterface
{
}
