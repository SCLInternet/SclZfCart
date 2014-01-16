<?php

namespace SclZfCart\Doctrine;

use SCL\Currency\MoneyFactory;
use SCL\Currency\TaxedPriceFactory;
use SclZfCart\Entity\MoneyFactoryAware;
use SclZfCart\Entity\PriceFactoryAware;

class PriceFactoryInjectorListener
{
    /**
     * @var MoneyFactory
     */
    private $moneyFactory;

    /**
     * @var TaxedPriceFactory
     */
    private $priceFactory;

    public function __construct(
        MoneyFactory $moneyFactory,
        TaxedPriceFactory $priceFactory
    ) {
        $this->moneyFactory = $moneyFactory;
        $this->priceFactory = $priceFactory;
    }

    public function postLoad($eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if ($entity instanceof MoneyFactoryAware) {
            $entity->setMoneyFactory($this->moneyFactory);
        }

        if ($entity instanceof PriceFactoryAware) {
            $entity->setPriceFactory($this->priceFactory);
        }
    }
}
