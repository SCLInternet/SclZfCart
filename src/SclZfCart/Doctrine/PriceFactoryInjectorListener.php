<?php

namespace SclZfCart\Doctrine;

use SCL\Currency\TaxedPriceFactory;
use SclZfCart\Entity\PriceFactoryAware;

class PriceFactoryInjectorListener
{
    /**
     * @var TaxedPriceFactory
     */
    private $priceFactory;

    public function __construct(TaxedPriceFactory $priceFactory)
    {
        $this->priceFactory = $priceFactory;
    }

    public function postLoad($eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if ($entity instanceof PriceFactoryAware) {
            $entity->setPriceFactory($this->priceFactory);
        }
    }
}
