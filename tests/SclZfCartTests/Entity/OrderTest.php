<?php

namespace SclZfCartTests\Entity;

use SclZfCart\Entity\Order;
use SclZfCart\Entity\OrderItem;
use SCL\Currency\TaxedPriceFactory;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    private $order;

    protected function setUp()
    {
        $this->order = new Order();
    }

    /*
     * getTotal()
     */

    public function test_getTotal_returns_zero_for_empty_order()
    {
        $this->assertEquals(0, $this->order->getTotal()->getValue());
    }

    public function test_getTotal_adds_price_and_tax_of_item()
    {
        $this->order->addItem($this->createOrderItem(10, 2));

        $this->assertEquals(12, $this->order->getTotal()->getValue());
    }

    public function test_getTotal_adds_prices_together()
    {
        $this->order->addItem($this->createOrderItem(10, 2));

        $this->order->addItem($this->createOrderItem(15, 3));

        $this->assertEquals(30, $this->order->getTotal()->getValue());
    }

    /*
     * Private methods
     */

    private function createOrderItem($price, $tax)
    {
        $orderItem = new OrderItem;

        $priceFactory = TaxedPriceFactory::createDefaultInstance();

        $orderItem->setPriceFactory($priceFactory);

        $orderItem->setPrice($priceFactory->createFromValues($price, $tax));

        return $orderItem;
    }
}
