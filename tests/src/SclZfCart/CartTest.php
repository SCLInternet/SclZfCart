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
     * @covers \SclZfCart\Cart::remove
     */
    public function testSingleProductAddAndRemove()
    {
        $uid = 'product123';

        $product = $this->getMock('SclZfCart\ProductInterface');

        $product->expects($this->atLeastOnce())->method('getUid')->will($this->returnValue($uid));

        $cartItem = $this->getMock('SclZfCart\CartItem');

        $cartItem->expects($this->once())
            ->method('setProduct')
            ->with($this->equalTo($product))
            ->will($this->returnValue($product));

        $cartItem->expects($this->once())
            ->method('getProduct')
            ->will($this->returnValue($product));

        $this->serviceLocator->expects($this->once())
            ->method('get')
            ->with($this->equalTo('SclZfCart\CartItem'))
            ->will($this->returnValue($cartItem));

        $result = $this->cart->add($product);

        $this->assertTrue($result);

        $items = $this->cart->getItems();

        $this->assertArrayHasKey($uid, $items);

        $this->assertEquals($cartItem, $items[$uid]);

        $this->assertEquals($product, $items[$uid]->getProduct());

        $this->cart->remove($product);

        $items = $this->cart->getItems();

        $this->assertEmpty($items);
    }

    /**
     * @covers \SclZfCart\Cart::add
     * @covers \SclZfCart\Cart::getItems
     */
    public function testMultiQuatityAdd()
    {
        $uid = 'product123';

        $product = $this->getMock('SclZfCart\ProductInterface');

        $product->expects($this->atLeastOnce())->method('getUid')->will($this->returnValue($uid));

        $cartItem = $this->getMock('SclZfCart\CartItem');

        $cartItem->expects($this->once())
            ->method('setProduct')
            ->with($this->equalTo($product))
            ->will($this->returnValue($product));

        $cartItem->expects($this->once())->method('setQuantity')->with($this->equalTo(1));
        $cartItem->expects($this->once())->method('add')->with($this->equalTo(2))->will($this->returnValue(true));

        $this->serviceLocator->expects($this->once())
            ->method('get')
            ->with($this->equalTo('SclZfCart\CartItem'))
            ->will($this->returnValue($cartItem));

        $result = $this->cart->add($product);
        $this->assertTrue($result, 'First add');

        $result = $this->cart->add($product, 2);
        $this->assertTrue($result, 'Second add');
    }
}
