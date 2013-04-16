<?php

namespace SclZfCart\Mapper;

use SclZfCart\Entity\OrderItemInterface;
use SclZfCart\Entity\OrderInterface;

/**
 * Inteface for OrderItemMapper.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface OrderItemMapperInterface
{
    /**
     * Creates a new instance of an order item object.
     *
     * @return OrderItemInterface
     */
    public function create();

    /**
     * Persists to the Order Item to storage.
     *
     * @param  OrderItemInterface $order
     * @return bool
     */
    public function save($order);

    /**
     * Loads a given order item from the database.
     *
     * @param  int $id
     * @return OrderItemInterface|null
     */
    public function findById($id);

    /**
     * Returns all orders items for a given order from the database.
     *
     * @param  OrderInterface
     * @return OrderItemInterface[]|null
     */
    public function fetchAllForOrder(OrderInterface $order);

    /**
     * Deletes the order item from the storage.
     *
     * @param  OrderItemInterface $itemOrId
     * @return bool
     */
    public function delete($item);
}
