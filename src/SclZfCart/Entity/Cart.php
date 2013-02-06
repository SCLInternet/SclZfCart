<?php

namespace SclZfCart\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Entity class for storing a cart to the database
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Cart
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var DateTime
     */
    protected $lastUpdated;

    /**
     * @var ArrayCollection
     * @ ORM\OneToMany(targetEntity="", mappedBy="customer", cascade={"remove"}, orphanRemoval=true)
     */
    protected $items;

    /**
     * Initialise internal objects
     */
    public function __construct()
    {
        $this->timestamp = new DateTime();
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Cart
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * @param DateTime $lastUpdated
     * @return Cart
     */
    public function setLastUpdated(DateTime $lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     * 
     * @return Cart
     */
    public function setItems(array $items)
    {
        $this->items = new ArrayCollection($items);
    }

    /**
     * @param CartItem $item
     */
    public function addItem(CartItem $item)
    {
        $this->items[$item->getUid] = $item;
    }
}
