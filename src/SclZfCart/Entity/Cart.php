<?php

namespace SclZfCart\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class Cart
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DateTime
     */
    private $lastUpdated;

    /**
     * @var ArrayCollection
     *
     * @todo Remove ArrayCollection type and see if Doctrine can still handle it.
     */
    private $items;

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
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @return DateTime
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    public function setLastUpdated(DateTime $lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param CartItem[] $items
     */
    public function setItems(array $items)
    {
        foreach ($items as $item) {
            $item->setCart($this);
        }

        $this->items = new ArrayCollection($items);
    }

    public function addItem(CartItem $item)
    {
        $item->setCart($this);
        $this->items[$item->getUid()] = $item;
    }
}
