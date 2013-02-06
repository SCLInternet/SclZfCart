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

        $this->serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        //$this->storage->setServiceLocator($this->serviceLocator);
    }

    /**
     * @covers \SclZfCart\Storage\DoctrineStorage::load
     */
    public function testLoad()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SclZfCart\Storage\DoctrineStorage::store
     */
    public function testStore()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SclZfCart\Storage\DoctrineStorage::collectGarbage
     */
    public function testCollectGarbage()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
