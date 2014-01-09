<?php

namespace SclZfCart\Entity;

class OrderItem extends AbstractItem
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }
}
