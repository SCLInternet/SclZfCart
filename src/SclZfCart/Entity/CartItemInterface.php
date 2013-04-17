<?php

namespace SclZfCart\Entity;

/**
 * Entity class interface for storing a cart item to the database.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartItemInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param  int $id
     * @return CartItem
     */
    public function setId($id);

    /**
     * @return Cart
     */
    public function getCart();

    /**
     * @param  CartInterface $cart
     * @return CartItem
     */
    public function setCart(CartInterface $cart);

    /**
     * @return string
     */
    public function getUid();

    /**
     * @param  string $uid
     * @return CartItem
     */
    public function setUid($uid);

    /**
     * Gets the value for quantity.
     *
     * @return int
     */
    public function getQuantity();

    /**
     * Sets the value for quantity.
     *
     * @param  int $quantity
     * @return self
     */
    public function setQuantity($quantity);

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
     * @return self
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getData();

    /**
     * @param  string $productData
     * @return CartItem
     */
    public function setData($data);
}
