<?php

namespace SclZfCart\Mapper;

use SclZfCart\Entity\OrderInterface;

/**
 * Inteface for OrderMapper.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface OrderMapperInterface
{
    /**
     * Creates a new instance of an order object.
     *
     * @return OrderInterface
     */
    public function create();

    /**
     * Persists to the Order to storage.
     *
     * @param  OrderInterface $order
     * @return bool
     */
    public function save($order);

    /**
     * Loads a given order from the database.
     *
     * @param  int $id
     * @return OrderInterface|null
     */
    public function findById($id);

    /**
     * Returns all orders from the database.
     *
     * @return OrderInterface[]|null
     */
    public function fetchAll();

    /**
     * Deletes the order from the storage.
     *
     * @param  OrderInterface $order
     * @return bool
     */
    public function delete($order);
}
