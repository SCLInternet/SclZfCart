<?php

namespace SclZfCart\Mapper;

use SclZfCart\Entity\OrderItem;
use SclZfCart\Entity\Order;
use SclZfGenericMapper\MapperInterface as GenericMapperInterface;

interface OrderItemMapperInterface extends GenericMapperInterface
{
    /**
     * @return OrderItem[]|null
     */
    public function findAllForOrder(Order $order);
}
