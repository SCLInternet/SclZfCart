<?php

namespace SclZfCart;

/**
 * Class that represents an item in the cart.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartItem
{
    /**
     * The product type of the item.
     *
     * @var ProductInterface
     */
    protected $product;

    /**
     * The number of this item in the cart.
     *
     * @var int
     */
    protected $quantity = 1;

    /**
     * Set the product for this item.
     *
     * @param ProductInterface $product
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     * Returns the product for this item.
     *
     * @return ProductInterface
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Sets the quantity for this item.
     *
     * @param unknown_type $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }
    
    /**
     * Returns the quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Increase the quantity by the given amount.
     *
     * @param int $amount
     */
    public function add($amount = 1)
    {
        $this->quantity += $amount;
    }

    /**
     * Increase the quantity by the given amount.
     *
     * @param int $amount
     *
     * @return boolean True if an item was removed, false if there a no items left
     */
    public function remove($amount = 1)
    {
        $this->quantity -= $amount;

        return ($this->quantity >= 1);
    }
}
