<?php

namespace SclZfCart;

/**
 * This class represents a collection of items which provide a UID
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class UidItemCollection
{
    /**
     * The items in the collection
     *
     * @var array
     */
    protected $items;

    /**
     * __construct
     *
     * @param  array $items
     * @return void
     */
    public function __construct($items = null)
    {
        $this->setItems($items);
    }

    /**
     * Sets the contents of the collection.
     *
     * @param  array $items
     * @return self
     */
    public function setItems($items)
    {
        $this->items = array();

        if (null === $items) {
            return $this;
        }

        if (!is_array($items) && !$items instanceof \Traversable) {
            throw new \DomainException(
                '$items must be an array or \Traversable'
            );
        }

        foreach ($items as $item) {
            $this->add($item);
        }

        return $this;
    }

    /**
     * Returns the items in the collection
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Returns the UIDs of all the items in the collection.
     *
     * @return array
     */
    public function getUids()
    {
        return array_keys($this->items);
    }

    /**
     * Adds an item to the collection
     *
     * @param  ProvidesUidInterface $item
     * @return self
     */
    public function add(ProvidesUidInterface $item)
    {
        $this->items[$item->getUid()] = $item;

        return $this;
    }

    /**
     * Returns a requested item from the collection
     *
     * @param  string $uid
     * @return ProvidesUidInterface|null
     */
    public function get($uid)
    {
        if (!isset($this->items[$uid])) {
            return null;
        }

        return $this->items[$uid];
    }

    /**
     * Removes a item from the collection.
     *
     * @param  ProvidesUidInterface|string $uidOrItem
     * @return self
     */
    public function remove($uidOrItem)
    {
        if ($uidOrItem instanceof ProvidesUidInterface) {
            $uidOrItem = $uidOrItem->getUid();
        }

        unset($this->items[$uidOrItem]);

        return $this;
    }
    

    /**
     * Returns a list of items from the specified uids
     * 
     * @param  array $uids
     * @return ProvidesUidInterface[]
     */
    protected function uidsToItems(array $uids)
    {
        $items = array();

        foreach ($uids as $uid) {
            if (!isset($this->items[$uid])) {
                throw new \DomainException('Item with '$uid' is not is the collection');
            }

            $items[$uid] = $this->items[$uid];
        }

        return $items;
    }

    /**
     * Returns the intersecting set of UIDs with the given collection.
     * 
     * @param  UidItemCollection $collection
     * @return array
     */
    public function intersectUids(UidItemCollection $collection)
    {
        return array_intersect($this->getUids(), $collection->getUids());
    }

    /**
     * Returns the intersecting set of items with the given collection
     * 
     * @param  UidItemCollection $collection
     * @return array
     */
    public function intersectItems(UidItemCollection $collection)
    {
        return $this->uidsToItems($this->intersectUids($collection->getUids());
    }

    /**
     * Returns the UIDs of the items which are in this collection but not the given one.
     * 
     * @param  UidItemCollection $collection 
     * @return self
     */
    public function diffUids(UidItemCollection $collection)
    {
        return array_diff($this->getUids(), $collection->getUids());
    }

    /**
     * Returns the items which are in this collection but not the given one.
     * 
     * @param UidItemCollection $collection collection 
     * 
     * @return void
     */
    public function diffItems(UidItemCollection $collection)
    {
        return $this->uidsToItems($this->diffUids($collection->getUids());
    }
}
