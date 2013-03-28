<?php

namespace SclZfCart\Storage;

/**
 * Unit test for {@see \SclZfCart\Storage\DoctrineStorage}
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class DoctrineStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @var DoctrineStorage
     */
    protected $storage;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $entityManager;

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
        $this->entityManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $this->itemHydrator = $this->getMock('SclZfCart\Hydrator\CartItemHydrator');

        $this->entityHydrator = $this->getMock('SclZfCart\Hydrator\CartItemEntityHydrator');

        $this->serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $this->storage = new DoctrineStorage(
            $this->entityManager,
            $this->serviceLocator,
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
        $itemsArray = array(
            0 => array(
                'uid' => 0,
                'type' => 'ItemType1'
            ),
            1 => array(
                'uid' => 1,
                'type' => 'ItemType2'
            ),
            2 => array(
                'uid' => 2,
                'type' => 'ItemType3'
            ),
        );

        $cartEntity = $this->getMock('SclZfCart\Entity\Cart');
        $cart = $this->getMock('SclZfCart\Cart', array('clear', 'add'));

        $cartItemEntities = array();
        $cartItems = array();
        for ($count = 0; $count < count($itemsArray); $count++) {
            $cartItemEntities[$count] = $this->getMock('SclZfCart\Entity\CartItem');
            $cartItems[$count] = $this->getMock('SclZfCart\CartItemInterface');
        }

        $this->entityManager->expects($this->once())
            ->method('find')
            ->with($this->equalTo('SclZfCart\Entity\Cart'), $this->equalTo($cartId))
            ->will($this->returnValue($cartEntity));

        $cart->expects($this->once())
            ->method('clear');

        $cartEntity->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue($cartItemEntities));

        $count = 0;
        for ($count = 0; $count < count($itemsArray); $count++) {
            $cartItemEntity = $cartItemEntities[$count];
            $cartItem = $cartItems[$count];
            $itemData = $itemsArray[$count];

            $cartItemEntity->expects($this->once())
                ->method('getType')
                ->will($this->returnValue($itemData['type']));

            $this->serviceLocator->expects($this->at($count))
                ->method('get')
                ->with($this->equalTo($itemData['type']))
                ->will($this->returnValue($cartItem));

            $this->entityHydrator->expects($this->at($count))
                ->method('extract')
                ->with($this->equalTo($cartItemEntity))
                ->will($this->returnValue($itemData));

            $this->itemHydrator->expects($this->at($count))
                ->method('hydrate')
                ->with($this->equalTo($itemData), $this->equalTo($cartItem));

            // @todo find out why at is per object
            $cart->expects($this->at($count + 1))
                ->method('add')
                ->with($this->equalTo($cartItem));
        }

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
