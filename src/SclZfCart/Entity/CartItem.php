<?php

namespace SclZfCart\Entity;

/**
 * Entity class for storing a cart item to the database.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartItem extends AbstractItem implements CartItemInterface
{
    /**
     * @var DoctrineCart
     */
    protected $cart;

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param  Cart $cart
     * @return void
     */
    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;
    }
}
