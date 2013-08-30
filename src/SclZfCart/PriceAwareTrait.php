<?php

namespace SclZfCart;

/**
 * Trait for objects which are price aware.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
trait PriceAwareTrait
{
    /**
     * Price amount,
     *
     * @var mixed
     */
    protected $price = 0.00;

    /**
     * Tax amount.
     *
     * @var float
     */
    protected $tax = 0.00;

    /**
     * Get the price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the price.
     *
     * @param  float $price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = (float) $price;
    }

    /**
     * Get the tax amount.
     *
     * @return float
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Sets the tax amount.
     *
     * @param  float $tax
     * @return void
     */
    public function setTax($tax)
    {
        $this->tax = (float) $tax;
    }
}
