<?php

namespace SclZfCart;

/**
 * Unit test for {@see \SclZfCart\Cart}
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * Prepare the object we'll be using
     */
    protected function setUp()
    {
        $this->serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $this->cart = new Cart;

        $this->cart->setServiceLocator($this->serviceLocator);
    }

    /**
     * @covers \SclZfCart\Cart::add
     * @covers \SclZfCart\Cart::getItems
     */
    public function testSingleAdd()
    {
        $uid = 'product123';

        $item = $this->getMock('SclZfCart\CartItemInterface');

        $item->expects($this->atLeastOnce())->method('getUid')->will($this->returnValue($uid));

        $result = $this->cart->add($item);

        $items = $this->cart->getItems();

        $this->assertArrayHasKey($uid, $items);

        $this->assertEquals($item, $items[$uid]);
    }

    /**
     * @covers \SclZfCart\Cart::remove
     * @covers \SclZfCart\Cart::getItems
     */
    public function testRemove()
    {
        $this->markTestIncomplete('Not implmenented yet');
    }
}
