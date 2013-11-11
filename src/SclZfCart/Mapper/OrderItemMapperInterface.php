<?php

namespace SclZfCart\Mapper;

use SclZfCart\Entity\OrderItemInterface;
use SclZfCart\Entity\OrderInterface;
use SclZfGenericMapper\MapperInterface as GenericMapperInterface;

/**
 * Inteface for OrderItemMapper.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface OrderItemMapperInterface extends GenericMapperInterface
{
    /**
     * Returns all orders items for a given order from the database.
     *
     * @param  OrderInterface
     * @return OrderItemInterface[]|null
     */
    public function findAllForOrder(OrderInterface $order);
}
