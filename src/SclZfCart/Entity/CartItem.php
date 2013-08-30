<?php

namespace SclZfCart\Entity;

use SclZfCart\PriceAwareTrait;
use SclZfCart\UidAwareTrait;
use SclZfCart\UnitPriceAwareTrait;

/**
 * Entity class for storing a cart item to the database.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartItem implements CartItemInterface
{
    use PriceAwareTrait;
    use UidAwareTrait;
    use UnitPriceAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var DoctrineCart
     */
    protected $cart;

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
     * @param  int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

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
     * @return void
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
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
     * @return void
     */
    public function setType($type)
    {
        $this->type = (string) $type;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param  string $productData
     * @return void
     */
    public function setData($data)
    {
        $this->data = (string) $data;
    }
}
