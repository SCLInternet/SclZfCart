<?php

namespace SclZfCart\Entity;

use SclZfCart\ProvidesUidInterface;

/**
 * Defines the interface of an order item object.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface OrderItemInterface extends ProvidesUidInterface
{
    /**
     * Gets the value for quantity.
     *
     * @return int
     */
    public function getQuantity();

    /**
     * Sets the value for quantity.
     *
     * @param  int $quantity
     * @return self
     */
    public function setQuantity($quantity);

    /**
     * Sets the value for uid.
     *
     * @param  string $uid
     * @return self
     */
    public function setUid($uid);

    /**
     * Gets the value for price.
     *
     * @return float
     */
    public function getPrice();

    /**
     * Sets the value for price.
     *
     * @param  float $price
     * @return self
     */
    public function setPrice($price);

    /**
     * Gets the value for type.
     *
     * @return string
     */
    public function getType();

    /**
     * Sets the value for type.
     *
     * @param  string $type
     * @return self
     */
    public function setType($type);

    /**
     * Gets the value for data.
     *
     * @return string
     */
    public function getData();

    /**
     * Sets the value for data.
     *
     * @param  string $data
     * @return self
     */
    public function setData($data);
}
