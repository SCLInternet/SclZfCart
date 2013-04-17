<?php

namespace SclZfCart\Entity;

use DateTime;

/**
 * Entity class interface for storing a cart to the database
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param  int $id
     * @return Cart
     */
    public function setId($id);

    /**
     * @return DateTime
     */
    public function getLastUpdated();

    /**
     * @param  DateTime $lastUpdated
     * @return Cart
     */
    public function setLastUpdated(DateTime $lastUpdated);

    /**
     * @return array
     */
    public function getItems();

    /**
     * @param  array $items
     * @return Cart
     */
    public function setItems(array $items);

    /**
     * @param CartItem $item
     */
    public function addItem(CartItemInterface $item);
}
