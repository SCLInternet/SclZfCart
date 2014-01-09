<?php

namespace SclZfCartTests\Service;

use SclZfCart\Service\CartToOrderService;

class CartToOrderServiceTest extends \PHPUnit_Framework_TestCase
{

    protected $service;

    protected $cartItemCreator;

    protected $itemHydrator;

    protected $orderItemMapper;

    protected function setUp()
    {
        $this->cartItemCreator = $this->getMock('SclZfCart\Service\CartItemCreatorInterface');

        $this->itemHydrator = $this->getMockBuilder('SclZfCart\Hydrator\ItemHydrator')
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->orderItemMapper = $this->getMock('SclZfCart\Mapper\OrderItemMapperInterface');

        $this->service = new CartToOrderService(
            $this->cartItemCreator,
            $this->itemHydrator,
            $this->orderItemMapper
        );
    }

    public function testConvertToCartItem()
    {
        $type = 'cart_item_type';
        $data = ['blah', 'blah'];
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

        $this->itemHydrator
             ->expects($this->at(0))
             ->method('extract')
             ->with($this->equalTo($orderItem))
             ->will($this->returnValue($data));

        $this->itemHydrator
             ->expects($this->at(1))
             ->method('hydrate')
             ->with($this->equalTo($data), $this->equalTo($cartItem))
             ->will($this->returnValue($cartItem));

        $result = $this->service->convertToCartItem($orderItem);

        $this->assertEquals($cartItem, $result);
    }
}
