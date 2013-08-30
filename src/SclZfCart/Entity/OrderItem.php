<?php

namespace SclZfCart\Entity;

use SclZfCart\PriceAwareTrait;
use SclZfCart\UidAwareTrait;
use SclZfCart\UnitPriceAwareTrait;

/**
 * Doctrine implementation of the the OrderInterface.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class OrderItem implements OrderItemInterface
{
    use PriceAwareTrait;
    use UidAwareTrait;
    use UnitPriceAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var DoctrineOrder
     */
    protected $order;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $data;

    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     *
     * @param  int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Sets the value for order.
     *
     * @param  DoctrineOrder $order
     * @return void
     */
    public function setOrder(DoctrineOrder $order)
    {
        $this->order = $order;
    }

    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * {@inheritDoc}
     *
     * @param  int $quantity
     * @return void
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $data
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
