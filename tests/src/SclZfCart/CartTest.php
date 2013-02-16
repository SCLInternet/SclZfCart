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
     * @covers \SclZfCart\Cart::getItem
     */
    public function testGetItem()
    {
        $uid = 'product123';

        $item = $this->getMock('SclZfCart\CartItemInterface');

        $item->expects($this->atLeastOnce())->method('getUid')->will($this->returnValue($uid));

        $result = $this->cart->add($item);

        $this->assertEquals($item, $this->cart->getItem($uid));
    }

    /**
     * @covers \SclZfCart\Cart::getItem
     */
    public function testGetUnknownItem()
    {
        $this->assertNull($this->cart->getItem('stupid_uid'));
    }

    /**
     * @covers \SclZfCart\Cart::remove
     * @covers \SclZfCart\Cart::getItems
     * @depends testGetItem
     * @depends testGetUnknownItem
     */
    public function testRemoveByUid()
    {
        $uid = 'product123';

        $item = $this->getMock('SclZfCart\CartItemInterface');

        $item->expects($this->atLeastOnce())->method('getUid')->will($this->returnValue($uid));

        $result = $this->cart->add($item);

        $this->cart->remove($uid);

        $this->assertNull($this->cart->getItem($uid));
    }

    /**
     * @covers \SclZfCart\Cart::remove
     * @covers \SclZfCart\Cart::getItems
     * @depends testGetItem
     * @depends testGetUnknownItem
     */
    public function testRemoveByItem()
    {
        $uid = 'product123';

        $item = $this->getMock('SclZfCart\CartItemInterface');

        $item->expects($this->atLeastOnce())->method('getUid')->will($this->returnValue($uid));

        $result = $this->cart->add($item);

        $this->cart->remove($item);

        $this->assertNull($this->cart->getItem($uid));
    }

    /**
     * @covers \SclZfCart\Cart::clear
     * @depends testGetItem
     * @depends testGetUnknownItem
     */
    public function testClear()
    {
        $uid = 'product123';
        $item1 = $this->getMock('SclZfCart\CartItemInterface');
        $item1->expects($this->atLeastOnce())->method('getUid')->will($this->returnValue($uid));
        $result = $this->cart->add($item1);

        $uid = 'product456';
        $item2 = $this->getMock('SclZfCart\CartItemInterface');
        $item2->expects($this->atLeastOnce())->method('getUid')->will($this->returnValue($uid));
        $result = $this->cart->add($item2);

        $this->cart->clear();

        $this->assertEquals(array(), $this->cart->getItems());
    }
}
