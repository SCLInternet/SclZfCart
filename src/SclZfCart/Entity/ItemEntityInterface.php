<?php

namespace SclZfCart\Entity;

use SclZfCart\CartItem\DataAwareInterface;
use SclZfCart\CartItemInterface as MainCartItemInterface;
use SclZfCart\CartItem\PriceAwareInterface;
use SclZfCart\CartItem\QuantityAwareInterface;
use SclZfCart\CartItem\TitleAwareInterface;
use SclZfCart\CartItem\UidAwareInterface;
use SclZfCart\CartItem\UnitPriceAwareInterface;

interface ItemEntityInterface extends
 MainCartItemInterface,
 DataAwareInterface,
 PriceAwareInterface,
 QuantityAwareInterface,
 TitleAwareInterface,
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
