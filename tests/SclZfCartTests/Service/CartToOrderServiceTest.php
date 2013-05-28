<?php

namespace SclZfCartTests\Service;

use SclZfCart\Service\CartToOrderService;

class CartToOrderServiceTest extends \PHPUnit_Framework_TestCase
{

    protected $service;

    protected $cartItemCreator;

    protected $cartItemHydrator;

    protected $orderItemHydrator;

    protected $orderItemMapper;

    protected function setUp()
    {
        $this->cartItemCreator = $this->getMock('SclZfCart\Service\CartItemCreatorInterface');

        $this->cartItemHydrator = $this->getMock('SclZfCart\Hydrator\CartItemHydrator');

        $this->orderItemHydrator = $this->getMock('SclZfCart\Hydrator\OrderItemEntityHydrator');

        $this->orderItemMapper = $this->getMock('SclZfCart\Mapper\OrderItemMapperInterface');

        $this->service = new CartToOrderService(
            $this->cartItemCreator,
            $this->cartItemHydrator,
            $this->orderItemHydrator,
            $this->orderItemMapper
        );
    }

    public function testCartToOrder()
    {
        $this->markTestIncomplete('Test needs to be written.');
    }

    public function testOrderToCart()
    {
        $this->markTestIncomplete('Test needs to be written.');
    }

    public function testConvertToCartItem()
    {
        $type = 'cart_item_type';
        $data = array('blah', 'blah');
        $cartItem = $this->getMock('SclZfCart\CartItemInterface');

        $orderItem = $this->getMock('SclZfCart\Entity\OrderItemInterface');

        $orderItem->expects($this->once())
                  ->method('getType')
                  ->will($this->returnValue($type));

        $this->cartItemCreator
             ->expects($this->once())
             ->method('create')
             ->with($this->equalTo($type))
             ->will($this->returnValue($cartItem));

        $this->orderItemHydrator
             ->expects($this->once())
             ->method('extract')
             ->with($this->equalTo($orderItem))
             ->will($this->returnValue($data));

        $this->cartItemHydrator
             ->expects($this->once())
             ->method('hydrate')
             ->with($this->equalTo($data), $this->equalTo($cartItem))
             ->will($this->returnValue($cartItem));

        $result = $this->service->convertToCartItem($orderItem);

        $this->assertEquals($cartItem, $result);
    }
}
