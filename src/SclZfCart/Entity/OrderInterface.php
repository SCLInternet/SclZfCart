<?php

namespace SclZfCart\Entity;

/**
 * Defines the interface of an order object.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface OrderInterface
{
    const STATUS_PENDING   = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED    = 'failed';

    /**
     * Returns the id of the order.
     *
     * @return int
     */
    public function getId();

    /**
     * Clears out the contents of the order.
     *
     * @return void
     */
    public function reset();

    /**
     * Get the order status.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set the order status
     *
     * @param  string $status
     * @return self
     */
    public function setStatus($status);

    /**
     * Gets a collection of all the items in the order.
     *
     * @return OrderItemInterface[]
     */
    public function getItems();

    /**
     * Adds an item to the order.
     *
     * @param  OrderItemInterface $item
     * @return self
     */
    public function addItem(OrderItemInterface $item);

    /**
     * Returns the total cost of the order.
     *
     * @return float
     */
    public function getTotal();
}
