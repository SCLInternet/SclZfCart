<?php

namespace SclZfCart;

/**
 * Trait for objects which are price aware.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
trait UnitPriceAwareTrait
{
    /**
     * Price amount,
     *
     * @var mixed
     */
    protected $unitPrice = 0.00;

    /**
     * Tax amount.
     *
     * @var float
     */
    protected $unitTax = 0.00;

    /**
     * Get the price for a single unit.
     *
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set the price for a single unit.
     *
     * @param  float $unitPrice
     * @return void
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = (float) $unitPrice;
    }

    /**
     * Get the tax amount for a single unit.
     *
     * @return float
     */
    public function getUnitTax()
    {
        return $this->unitTax;
    }

    /**
     * Sets the tax amount for a single unit.
     *
     * @param  float $unitTax
     * @return void
     */
    public function setUnitTax($unitTax)
    {
        $this->unitTax = (float) $unitTax;
    }
}
