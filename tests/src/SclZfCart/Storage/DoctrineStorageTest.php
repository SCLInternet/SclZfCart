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
    private $serviceLocator;

    /**
     * @var DoctrineStorage
     */
    private $storage;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $entityManager;

    /**
     * @var \SclZfCart\Hydrator\CartHydrator
     */
    private $hydrator;

    /**
     * Prepare the object we'll be using
     */
    protected function setUp()
    {
        $this->entityManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $this->hydrator = $this->getMock('SclZfCart\Hydrator\CartHydrator');

        $this->storage = new DoctrineStorage($this->entityManager, $this->hydrator);
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
        $itemsArray = array(1, 2, 3);

        $cart = $this->getMock('SclZfCart\Cart');
        $cartEntity = $this->getMock('SclZfCart\Entity\Cart');
        $items = $this->getMock('Doctrine\Common\Collections\ArrayCollection');

        $items->expects($this->atLeastOnce())->method('toArray')->will($this->returnValue($itemsArray));

        $cartEntity->expects($this->atLeastOnce())->method('getItems')->will($this->returnValue($items));

        $this->entityManager->expects($this->once())
            ->method('find')
            ->with($this->equalTo('SclZfCart\Entity\Cart'), $this->equalTo($cartId))
            ->will($this->returnValue($cartEntity));
        
        $this->hydrator->expects($this->once())
            ->method('hydrate')
            ->with($this->equalTo($itemsArray), $this->equalTo($cart));

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
