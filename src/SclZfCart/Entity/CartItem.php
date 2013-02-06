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
    protected $productType;

    /**
     * @var string
     */
    protected $productData;

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
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return CartItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @param string $productType
     * @return CartItem
     */
    public function setProductType($productType)
    {
        $this->productType = (string) $productType;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductData()
    {
        return $this->productData;
    }

    /**
     * @param string $productData
     * @return CartItem
     */
    public function setProductData($productData)
    {
        $this->productData = (string) $productData;
        return $this;
    }
}
