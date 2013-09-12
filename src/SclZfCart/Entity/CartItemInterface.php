<?php

namespace SclZfCart\Entity;


/**
 * Entity class interface for storing a cart item to the database.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartItemInterface extends ItemEntityInterface
{
    /**
     * @return CartInterface
     */
    public function getCart();

    /**
     * @param  CartInterface $cart
     * @return void
     */
    public function setCart(CartInterface $cart);
}
