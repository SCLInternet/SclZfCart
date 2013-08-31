<?php

namespace SclZfCart\Entity;

use SclZfCart\CartItem\DataAwareInterface;
use SclZfCart\CartItem\PriceAwareInterface;
use SclZfCart\CartItem\QuantityAwareInterface;
use SclZfCart\CartItem\UidAwareInterface;
use SclZfCart\CartItem\UnitPriceAwareInterface;

/**
 * Entity class interface for storing a cart item to the database.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartItemInterface extends
    DataAwareInterface,
    PriceAwareInterface,
    QuantityAwareInterface,
    UidAwareInterface,
    UnitPriceAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param  int $id
     * @return void
     */
    public function setId($id);

    /**
     * @return CartInterface
     */
    public function getCart();

    /**
     * @param  CartInterface $cart
     * @return void
     */
    public function setCart(CartInterface $cart);

    /**
     * Gets the value for type.
     *
     * @return string
     */
    public function getType();

    /**
     * Sets the value for type.
     *
     * @param  string $type
     * @return void
     */
    public function setType($type);
}
