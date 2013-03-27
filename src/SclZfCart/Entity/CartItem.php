<?php

namespace SclZfCart\Entity;

/**
 * Entity class for storing a cart item to the database.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartItem
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @var string
     */
    protected $uid;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $data;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return CartItem
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     *
     * @return CartItem
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     *
     * @return CartItem
     */
    public function setUid($uid)
    {
        $this->uid = (string) $uid;
        return $this;
    }

    /**
     * Gets the value for quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Sets the value for quantity.
     *
     * @param  int $quantity
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
        return $this;
    }

    /**
     * Gets the value for type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the value for type.
     *
     * @param  string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = (string) $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $productData
     * @return CartItem
     */
    public function setData($data)
    {
        $this->data = (string) $data;
        return $this;
    }
}
