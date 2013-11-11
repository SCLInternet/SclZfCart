<?php

namespace SclZfCart\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use SclZfUtilities\Model\CurrencyValue;

/**
 * Doctrine implementation of the the OrderInterface
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Order implements OrderInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var ArrayCollection
     * @todo Remove reliance of ArrayCollection
     */
    protected $items;

    /**
     * Initialise the values in the order.
     */
    public function __construct()
    {
        $this->reset();
    }

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
     * @return void
     */
    public function reset()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $status
     * @return void
    */
    public function setStatus($status)
    {
        // @todo value checking
        $this->status = (string) $status;
    }

    /**
     * {@inheritDoc}
     *
     * @return OrderItemInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * {@inheritDoc}
     *
     * @param  OrderItemInterface $item
     * @return void
     */
    public function addItem(OrderItemInterface $item)
    {
        $item->setOrder($this);
        $this->items[] = $item;
    }

    /**
     * {@inheritDoc}
     *
     * @return float
     */
    public function getTotal()
    {
        $total = new CurrencyValue(0);

        foreach ($this->items as $item) {
            $total->add($item->getPrice());
            $total->add($item->getTax());
        }

        return $total->get();
    }
}
