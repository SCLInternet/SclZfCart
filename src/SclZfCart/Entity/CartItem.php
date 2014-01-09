<?php

namespace SclZfCart\Entity;

class CartItem extends AbstractItem
{
    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }
}
