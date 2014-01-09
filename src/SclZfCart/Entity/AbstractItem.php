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
use SCL\Currency\TaxedPrice;
use SCL\Currency\TaxedPriceFactory;

/**
 * Abstract class for storing an item entity.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
abstract class AbstractItem implements
    PriceFactoryAware,
    DataAwareInterface,
    PriceAwareInterface,
    QuantityAwareInterface,
    TitleProviderInterface,
    UidAwareInterface,
    UnitPriceAwareInterface
{
    use TitleAwareTrait;
    use QuantityAwareTrait;
    use UidAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $data;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $tax;

    /**
     * @var int
     */
    protected $unitPrice;

    /**
     * @var int
     */
    protected $unitTax;

    /**
     * @var TaxedPriceFactory
     */
    private $priceFactory;

    public function setPriceFactory(TaxedPriceFactory $priceFactory)
    {
        $this->priceFactory = $priceFactory;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = (string) $data;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = (string) $type;
    }

    /**
     * @return TaxedPrice
     */
    public function getPrice()
    {
        return $this->priceFactory->createFromUnits($this->price, $this->tax);
    }

    public function setPrice(TaxedPrice $price)
    {
        $this->price = $price->getAmount()->getUnits();
        $this->tax   = $price->getTax()->getUnits();
    }

    /**
     * @return TaxedPrice
     */
    public function getUnitPrice()
    {
        return $this->priceFactory->createFromUnits($this->unitPrice, $this->unitTax);
    }

    public function setUnitPrice(TaxedPrice $price)
    {
        $this->unitPrice = $price->getAmount()->getUnits();
        $this->unitTax   = $price->getTax()->getUnits();
    }
}
