<?php

namespace SclZfCart\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use SclZfUtilities\Model\CurrencyValue;
use SclZfCart\Customer\CustomerInterface;
use SCL\Currency\Money;
use SCL\Currency\Money\Accumulator;

class Order
{
    const STATUS_PENDING   = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED    = 'failed';

    /**
     * @var int
     */
    private $id;

    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * @var string
     */
    private $status;

    /**
     * @var ArrayCollection
     * @todo Remove reliance of ArrayCollection
     */
    private $items;

    public function __construct()
    {
        $this->reset();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    public function reset()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        // @todo value checking
        $this->status = (string) $status;
    }

    /**
     * @return OrderItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    public function addItem(OrderItem $item)
    {
        $item->setOrder($this);
        $this->items[] = $item;
    }

    /**
     * @return Money
     */
    public function getTotal()
    {
        $accumulator = new Accumulator(
            // @todo Create this properly!
            \SCL\Currency\CurrencyFactory::createDefaultInstance()->getDefaultCurrency()
        );

        foreach ($this->items as $item) {
            $price = $item->getPrice();
            $accumulator->add($price->getAmount());
            $accumulator->add($price->getTax());
        }

        return $accumulator->calculateTotal();
    }
}
