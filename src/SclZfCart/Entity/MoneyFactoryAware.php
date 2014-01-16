<?php

namespace SclZfCart\Entity;

use SCL\Currency\MoneyFactory;

interface MoneyFactoryAware
{
    public function setMoneyFactory(MoneyFactory $moneyFactory);
}
