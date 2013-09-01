<?php

namespace SclZfCart\Entity;

use SclZfCart\CartItem\DataAwareInterface;
use SclZfCart\CartItem\PriceAwareInterface;
use SclZfCart\CartItem\QuantityAwareInterface;
use SclZfCart\CartItem\UidAwareInterface;
use SclZfCart\CartItem\UnitPriceAwareInterface;
use SclZfCart\CartItemInterface as MainCartItemInterface;

/**
 * Defines the interface of an order item object.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface OrderItemInterface extends
    MainCartItemInterface,
    DataAwareInterface,
    PriceAwareInterface,
    QuantityAwareInterface,
    UidAwareInterface,
    UnitPriceAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param  int $id
     * @return void
     */
    public function setId($id);

    /**
     * Get the order this item belongs to.
     *
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * Set the order this item belongs to.
     *
     * @param  OrderInterface $order
     * @return void
     */
    public function setOrder(OrderInterface $order);

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
     * @return void
     */
    public function setType($type);
}
