<?php

namespace SclZfCart\Storage;

/**
 * Unit test for {@see \SclZfCart\Storage\DoctrineStorage}
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DoctrineStorage
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
     * @var \SclZfCart\Hydrator\CartItemHydrator
     */
    protected $itemHydrator;

    /**
     * @var \SclZfCart\Hydrator\CartItemEntityHydrator
     */
    protected $entityHydrator;

    /**
     * Prepare the object we'll be using
     */
    protected function setUp()
    {
        $this->cartMapper = $this->getMock('SclZfCart\Mapper\CartMapperInterface');

        $this->cartItemMapper = $this->getMock('SclZfCart\Mapper\CartItemMapperInterface');

        $this->itemCreator =$this->getMock('SclZfCart\Service\CartItemCreatorInterface');

        $this->itemHydrator = $this->getMock('SclZfCart\Hydrator\CartItemHydrator');

        $this->entityHydrator = $this->getMock('SclZfCart\Hydrator\CartItemEntityHydrator');

        $this->storage = new CartStorage(
            $this->cartMapper,
            $this->cartItemMapper,
            $this->itemCreator,
            $this->itemHydrator,
            $this->entityHydrator
        );
    }

    /**
     * @covers \SclZfCart\Storage\DoctrineStorage::load
     * @expectedException \SclZfCart\CartNotFoundException
     */
    /*
    public function testLoadFails()
    {
        $cartId = 27;
        $cart = $this->getMock('SclZfCart\Cart');
        $cartEntity = $this->getMock('SclZfCart\Entity\Cart');

        $this->entityManager->expects($this->once())
            ->method('find')
            ->with($this->equalTo('SclZfCart\Entity\Cart'), $this->equalTo($cartId))
            ->will($this->returnValue(false));

        $this->storage->load($cartId, $cart);
    }
    */

    /**
     * @covers \SclZfCart\Storage\DoctrineStorage::load
     */
    public function testLoad()
    {
        $cartId = 27;

        $cart = $this->getMock('SclZfCart\Cart', array('clear', 'add'));

        // $this->cartEntity = $this->cartMapper->findById($id);
        $this->cartMapper->expects($this->once())
            ->method('findById')
            ->with($this->equalTo($cartId))
            ->will($this->returnValue($cart));

        // $cart->clear();
        $cart->expects($this->once())
            ->method('clear');

        // foreach ($this->cartEntity->getItems() as $entity) { .. }
        $cartItemEntity = $this->getMock('SclZfCart\Entity\CartItemEntityInterface');
        $cartItemEntities = array($cartItemEntity);

        $cartEntity = $this->getMock('SclZfCart\Entity\CartInterface');
        $cartEntity->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue($cartItemEntities));

        // $item = $this->itemCreator->create($entity->getType());
        $cartItemEntityType = 'random_type';
        $cartItemEntity->expects($this->once())
            ->method('getType')
            ->will($this->returnValue($cartItemEntityType));

        $cartItem = $this->getMock('SclZfCart\CartItemInterface');

        $this->itemCreator->expects($this->once())
            ->method('create')
            ->with($this->equalTo($cartItemEntityType))
            ->will($this->returnValue($cartItem));

        // $data = $this->cartItemEntityHydrator->extract($entity);
        $data = 'abc';
        $this->entityHydrator->expects($this->once())
            ->method('extract')
            ->with($this->equalTo($cartItemEntity))
            ->will($this->returnValue($data));

        $this->itemHydrator->expects($this->once())
            ->method('hydrate')
            ->with($this->equalTo($data), $this->equalTo($cartItem));

        $this->storage->load($cartId, $cart);
    }

    /**
     * @covers \SclZfCart\Storage\DoctrineStorage::store
     */
    public function testStore()
    {
        $this->markTestIncomplete(
            'Class implementation needs to be fixed first.'
        );
    }

    /**
     * @covers \SclZfCart\Storage\DoctrineStorage::collectGarbage
     */
    public function testCollectGarbage()
    {
        $this->markTestIncomplete(
            'This function & test has not been implemented yet.'
        );
    }
}
