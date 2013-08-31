<?php

namespace SclZfCart\Entity;

/**
 * Doctrine implementation of the the OrderInterface.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class OrderItem extends AbstractItem implements OrderItemInterface
{
    /**
     * @var DoctrineOrder
     */
    protected $order;

    /**
     * {@inheritDoc}
     *
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Sets the value for order.
     *
     * @param  OrderInterface $order
     * @return void
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
    }
}
