<?php

namespace SclZfCart\CartItem;

use SCL\Currency\TaxedPrice;

trait PriceAwareTrait
{
    /**
     * @var TaxedPrice
     */
    private $price;

    /**
     * @return TaxedPrice
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice(TaxedPrice $price)
    {
        $this->price = $price;
    }
}
