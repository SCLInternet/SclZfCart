<?php

namespace SclZfCart\Entity;

use SCL\Currency\TaxedPriceFactory;

interface PriceFactoryAware
{
    public function setPriceFactory(TaxedPriceFactory $priceFactory);
}
