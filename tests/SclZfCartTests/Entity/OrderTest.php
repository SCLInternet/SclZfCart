<?php

namespace SclZfCartTests\Entity;

use SclZfCart\Entity\Order;
use SclZfCart\Entity\OrderItem;

/**
 * Unit tests for {@see Order}.
 *
 * @covers SclZfCart\Entity\Order
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class OrderTest extends \PHPUnit_Framework_TestCase
{
    protected $order;

    /**
     * Set up the instance to be tested.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->order = new Order();
    }

    /*
     * getTotal()
     */

    public function test_getTotal_returns_zero_for_empty_order()
    {
        $this->assertEquals(0, $this->order->getTotal());
    }

    public function test_getTotal_adds_price_and_tax_of_item()
    {
        $this->order->addItem($this->createOrderItem(10, 2));

        $this->assertEquals(12, $this->order->getTotal());
    }

    public function test_getTotal_adds_prices_together()
    {
        $this->order->addItem($this->createOrderItem(10, 2));

        $this->order->addItem($this->createOrderItem(15, 3));

        $this->assertEquals(30, $this->order->getTotal());
    }

    /*
     * Private methods
     */

    private function createOrderItem($price, $tax)
    {
        $orderItem = new OrderItem;

        $orderItem->setPrice($price);
        $orderItem->setTax($tax);

        return $orderItem;
    }
}
