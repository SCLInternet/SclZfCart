<?php

namespace SclZfCart\Entity;

/**
 * Defines the interface of an order item object.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface OrderItemInterface extends ItemEntityInterface
{
    /**
     * Get the order this item belongs to.
     *
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * Set the order this item belongs to.
     *
     * @param  OrderInterface $order
     * @return void
     */
    public function setOrder(OrderInterface $order);
}
