<?php

namespace SclZfCart\Entity;

use SclZfCart\CartItem\DataAwareInterface;
use SclZfCart\CartItem\PriceAwareInterface;
use SclZfCart\CartItem\PriceAwareTrait;
use SclZfCart\CartItem\QuantityAwareInterface;
use SclZfCart\CartItem\QuantityAwareTrait;
use SclZfCart\CartItem\TitleAwareTrait;
use SclZfCart\CartItem\TitleProviderInterface;
use SclZfCart\CartItem\UidAwareInterface;
use SclZfCart\CartItem\UidAwareTrait;
use SclZfCart\CartItem\UnitPriceAwareInterface;
use SclZfCart\CartItem\UnitPriceAwareTrait;

/**
 * Abstract class for storing an item entity.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
abstract class AbstractItem implements
    DataAwareInterface,
    PriceAwareInterface,
    QuantityAwareInterface,
    TitleProviderInterface,
    UidAwareInterface,
    UnitPriceAwareInterface
{
    use TitleAwareTrait;
    use PriceAwareTrait;
    use QuantityAwareTrait;
    use UidAwareTrait;
    use UnitPriceAwareTrait;

    /**
     * The entity id.
     *
     * @var int
     */
    protected $id;

    /**
     * The serialized data.
     *
     * @var string
     */
    protected $data;

    /**
     * The type of item to be stored in this entity.
     *
     * @var string
     */
    protected $type;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = (string) $data;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = (string) $type;
    }
}
