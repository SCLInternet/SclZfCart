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
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $quantity = (int) $quantity;

        if ($quantity < 0) {
            $quantity = 0;
        }

        if (!$this->product->canAddMoreThanOne()) {
            $quantity = $quantity > 0 ? 1 : 0;
        }

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
     *
     * @return boolean False if the quantity was not updated.
     */
    public function add($amount = 1)
    {
        $this->setQuantity($this->quantity + $amount);
    }

    /**
     * Increase the quantity by the given amount.
     *
     * @param int $amount
     *
     * @return boolean True if there are items left, false if there a no items left
     */
    public function remove($amount = 1)
    {
        $this->quantity -= $amount;

        return ($this->quantity >= 1);
    }
}
