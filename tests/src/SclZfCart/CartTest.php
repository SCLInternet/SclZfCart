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
     * @var Cart
     */
    protected $cart;

    /**
     * Prepare the object we'll be using
     */
    protected function setUp()
    {
        $this->cart = new Cart;
    }

    /**
     * @covers \SclZfCart\Cart::setEventManager
     * @covers \SclZfCart\Cart::getEventManager
     */
    public function testSetEventManager()
    {
        $eventManager = $this->getMock('Zend\EventManager\EventManagerInterface');

        $eventManager->expects($this->once())
            ->method('setIdentifiers')
            ->with($this->equalTo(array('SclZfCart\Cart', 'SclZfCart\Cart')));

        $eventManager->expects($this->once())
            ->method('setEventClass')
            ->with($this->equalTo('SclZfCart\CartEvent'));

        $this->cart->setEventManager($eventManager);

        $this->assertEquals(
            $eventManager,
            $this->cart->getEventManager(),
            'Returned EventManager didn\'t match the one set'
        );
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

        $this->cart->add($item);

        $items = $this->cart->getItems();

        $this->assertArrayHasKey($uid, $items);

        $this->assertEquals($item, $items[$uid]);
    }

    /**
     * @depends testSingleAdd
     * @covers \SclZfCart\Cart::add
     * @covers \SclZfCart\Cart::getItems
     */
    public function testAddingTwoItemsWithTheSameUid()
    {
        $uid = 'product123';

        $item1 = $this->getMock('SclZfCart\CartItemInterface');

        $item1->expects($this->atLeastOnce())->method('getUid')->will($this->returnValue($uid));

        $this->cart->add($item1);

        $item2 = $this->getMock('SclZfCart\CartItemInterface');

        $item2->expects($this->atLeastOnce())->method('getUid')->will($this->returnValue($uid));

        $item1->expects($this->once())->method('getQuantity')->will($this->returnValue(3));
        $item2->expects($this->once())->method('getQuantity')->will($this->returnValue(4));
        $item1->expects($this->once())->method('setQuantity')->with($this->equalTo(7));

        $this->cart->add($item2);
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
