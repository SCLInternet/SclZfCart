<?php

namespace SclZfCart\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\XmlRpc\Value\String;

/**
 * Doctrine implementation of the the OrderInterface
 *
 * @ORM\Entity
 * @ORM\Table(name="cart_order")
 */
class DoctrineOrder implements OrderInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String
     * @ORM\Column(type="string")
     */
    protected $status;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SclZfCart\Entity\DoctrineOrderItem", cascade={"all"}, mappedBy="order")
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
     * @return self
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
     * @return self
     */
    public function addItem(OrderItemInterface $item)
    {
        $item->setOrder($this);
        $this->items[] = $item;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return float
     */
    public function getTotal()
    {
        return 0;
    }
}
