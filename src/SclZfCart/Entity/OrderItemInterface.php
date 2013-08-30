<?php

namespace SclZfCart\Entity;

use SclZfCart\PriceAwareInterface;
use SclZfCart\UidAwareInterface;
use SclZfCart\UnitPriceAwareInterface;

/**
 * Defines the interface of an order item object.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface OrderItemInterface extends
    PriceAwareInterface,
    UidAwareInterface,
    UnitPriceAwareInterface
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
