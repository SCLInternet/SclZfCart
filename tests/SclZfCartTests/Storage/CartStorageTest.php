<?php

namespace SclZfCartTests\Storage;

use SclZfCart\Storage\CartStorage;

/**
 * Unit test for {@see \SclZfCart\Storage\CartStorage}
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CartStorage
     */
    protected $storage;

    /**
     * @var \SclZfCart\Mapper\CartMapperInterface
     */
    protected $cartMapper;

    /**
     * @var \SclZfCart\Mapper\CartItemMapperInterface
     */
    protected $cartItemMapper;

    /**
     * @var \SclZfCart\Service\CartItemCreatorInterface
     */
    protected $itemCreator;

    /**
     * @var \SclZfCart\Hydrator\ItemHydrator
     */
    protected $itemHydrator;

    /**
     * Prepare the object we'll be using
     */
    protected function setUp()
    {
        $this->cartMapper = $this->getMock('SclZfCart\Mapper\CartMapperInterface');

        $this->cartItemMapper = $this->getMock('SclZfCart\Mapper\CartItemMapperInterface');

        $this->itemCreator =$this->getMock('SclZfCart\Service\CartItemCreatorInterface');

        $this->itemHydrator = $this->getMockBuilder('SclZfCart\Hydrator\ItemHydrator')
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->storage = new CartStorage(
            $this->cartMapper,
            $this->cartItemMapper,
            $this->itemCreator,
            $this->itemHydrator
        );
    }

    /**
     * @covers \SclZfCart\Storage\CartStorage::load
     * @expectedException \SclZfCart\Exception\CartNotFoundException
     */
    public function testLoadFails()
    {
        $cartId = 27;
        $cart = $this->getMock('SclZfCart\Cart');

        $this->cartMapper->expects($this->once())
            ->method('findById')
            ->with($this->equalTo($cartId))
            ->will($this->returnValue(null));


        $this->storage->load($cartId, $cart);
    }

    /**
     * @covers \SclZfCart\Storage\CartStorage::load
     */
    public function testLoadWithNoItems()
    {
        $cartId = 27;

        $cart = $this->getMock('SclZfCart\Cart', ['clear', 'add']);

        $cartEntity = $this->getMock('SclZfCart\Entity\CartInterface');

        $this->cartMapper->expects($this->once())
            ->method('findById')
            ->with($this->equalTo($cartId))
            ->will($this->returnValue($cartEntity));

        $cart->expects($this->once())
            ->method('clear');

        $cartEntity->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([]));

        $result = $this->storage->load($cartId, $cart);

        $this->assertEquals($cart, $result, 'The load method should return the Cart object');
    }

    /**
     * @covers \SclZfCart\Storage\CartStorage::store
     */
    public function testStore()
    {
        $cartId = '43';

        $cart = $this->getMock('SclZfCart\Cart');

        $cartEntity = $this->getMock('SclZfCart\Entity\CartInterface');

        $this->cartMapper->expects($this->once())
            ->method('create')
            ->will($this->returnValue($cartEntity));

        $this->cartMapper->expects($this->once())
            ->method('save')
            ->with($this->equalTo($cartEntity));

        $cartEntity->expects($this->once())
            ->method('getId')
            ->will($this->returnValue($cartId));

        $result = $this->storage->store($cart);

        $this->assertEquals($cartId, $result, 'Store should return the ID from the entity');
    }
}
