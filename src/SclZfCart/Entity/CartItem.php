<?php

namespace SclZfCart;

/**
 * Entity class for storing a cart item to the database
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
     * @var int
     */
    protected $cartId;

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
     * @return int
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * @param int $id
     * @return CartItem
     */
    public function setCartId($id)
    {
        $this->cartId = (int) $id;
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
