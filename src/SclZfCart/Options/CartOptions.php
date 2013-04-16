<?php

namespace SclZfCart\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Processes the options for the SclZfCart module.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartOptions extends AbstractOptions
{
    /**
     * The class to be used for the order entity.
     *
     * @var string
     */
    protected $orderClass;

    /**
     * The class to be used for the order item entity.
     *
     * @var string
     */
    protected $orderItemClass;

    /**
     * The mapper class to be used to store order entities.
     *
     * @var string
     */
    protected $orderMapperClass;

    /**
     * The mapper class to be used to store order item entities.
     *
     * @var string
     */
    protected $orderItemMapperClass;

    /**
     * Gets the value for orderClass.
     *
     * @return string
     */
    public function getOrderClass()
    {
        return $this->orderClass;
    }

    /**
     * Sets the value for orderClass.
     *
     * @param  string $orderClass
     * @return self
     */
    public function setOrderClass($orderClass)
    {
        $this->orderClass = (string) $orderClass;

        return $this;
    }

    /**
     * Gets the value for orderItemClass.
     *
     * @return string
     */
    public function getOrderItemClass()
    {
        return $this->orderItemClass;
    }

    /**
     * Sets the value for orderItemClass.
     *
     * @param  string $itemClass
     * @return self
     */
    public function setOrderItemClass($itemClass)
    {
        $this->orderItemClass = (string) $itemClass;

        return $this;
    }

    /**
     * Gets the value for orderMapperClass.
     *
     * @return string
     */
    public function getOrderMapperClass()
    {
        return $this->orderMapperClass;
    }

    /**
     * Sets the value for orderMapperClass.
     *
     * @param  string $orderMapperClass
     * @return self
     */
    public function setOrderMapperClass($orderMapperClass)
    {
        $this->orderMapperClass = (string) $orderMapperClass;

        return $this;
    }
    /**
     * Gets the value for orderItemMapperClass.
     *
     * @return string
     */
    public function getOrderItemMapperClass()
    {
        return $this->orderItemMapperClass;
    }
    /**
     * Sets the value for orderItemMapperClass.
     *
     * @param  string $itemMapperClass
     * @return self
     */
    public function setOrderItemMapperClass($itemMapperClass)
    {
        $this->orderItemMapperClass = (string) $itemMapperClass;

        return $this;
    }
}
