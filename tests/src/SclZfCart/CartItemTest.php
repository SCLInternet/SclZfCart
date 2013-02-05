<?php

namespace SclZfCart;

/**
 * The shopping cart item test
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CartItem
     */
    private $item;

    /**
     * @var ProductInterface
     */
    private $product;

    protected function setUp()
    {
        $this->product = $this->getMock('SclZfCart\ProductInterface');

        $this->item = new CartItem();

        $this->item->setProduct($this->product);
    }

    /**
     * @covers \SclZfCart\CartItem::getProduct
     */
    public function testSetGetProduct()
    {
        $this->assertEquals($this->product, $this->item->getProduct());
    }

    /**
     * @covers \SclZfCart\CartItem::setQuantity
     * @covers \SclZfCart\CartItem::add
     * @covers \SclZfCart\CartItem::getQuantity
     */
    public function testSetQuantityWithSingleAddProduct()
    {
        $this->product->expects($this->any())->method('canAddMoreThanOne')->will($this->returnValue(false));

        $this->item->setQuantity(5);

        $this->assertEquals(1, $this->item->getQuantity(), 'Testing setQuantity');

        $this->item->add(3);

        $this->assertEquals(1, $this->item->getQuantity(), 'Testing add()');
    }

    /**
     * @covers \SclZfCart\CartItem::setQuantity
     * @covers \SclZfCart\CartItem::add
     * @covers \SclZfCart\CartItem::getQuantity
     */
    public function testSetQuantityWithMultiAddProduct()
    {
        $this->product->expects($this->any())->method('canAddMoreThanOne')->will($this->returnValue(true));

        $this->item->setQuantity(5);

        $this->assertEquals(5, $this->item->getQuantity(), 'Testing setQuantity');

        $this->item->add(3);

        $this->assertEquals(8, $this->item->getQuantity(), 'Testing add()');
    }

    /**
     * @depends testSetQuantityWithMultiAddProduct
     * @covers \SclZfCart\CartItem::remove
     */
    public function testRemove()
    {
        $this->product->expects($this->any())->method('canAddMoreThanOne')->will($this->returnValue(true));

        $this->item->setQuantity(5);

        $this->assertTrue($this->item->remove(3), 'Items left in the cart');

        $this->assertEquals(2, $this->item->getQuantity());

        $this->assertFalse($this->item->remove(2), 'No items in the cart');
    }
}
