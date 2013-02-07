<?php

namespace SclZfCart\Storage;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfCart\Cart;
use SclZfCart\Entity\Cart as CartEntity;
use SclZfCart\Exception\CartNotFoundException;
use SclZfCart\Hydrator\CartHydrator;

/**
 * Storage class for storing a cart using doctrine.
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @todo Redesign and refactor this class.
 */
class DoctrineStorage implements StorageInterface
{
    /**
     * @var CartEntity
     */
    private $cartEntity = null;

    /**
     * @var ObjectManager
     */
    private $entityManager;

    /**
     * @var CartHydrator
     */
    private $hydrator;

    /**
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager, CartHydrator $hydrator)
    {
        $this->entityManager = $entityManager;
        $this->hydrator = $hydrator;
    }

    /**
     * {@inheritDoc}
     *
     * @param int  $id
     * @param Cart $cart
     * @return void
     * @throws CartNotFoundException
     */
    public function load($id, Cart $cart)
    {
        $this->cartEntity = $this->entityManager->find('SclZfCart\Entity\Cart', $id);

        if (!$this->cartEntity) {
            throw new CartNotFoundException("Cart with \"%id\" not found.");
        }

        $this->hydrator->hydrate($this->cartEntity->getItems()->toArray(), $cart);
    }

    /**
     * {@inheritDoc}
     *
     * @param Cart $cart
     * @return int The cart identifier
     */
    public function store(Cart $cart)
    {
        if (null === $this->cartEntity) {
            $this->cartEntity = new CartEntity();
        }

        $this->cartEntity->setLastUpdated(new \DateTime());

        $items = $this->hydrator->extract($cart);

        $entityItems = array();

        foreach ($this->cartEntity->getItems()->toArray() as $key => $entity) {
            if (!isset($items[$entity->getUid()])) {
                $this->entityManager->remove($entity);
                continue;
            }

            $entityItems[$entity->getUid()] = $entity;
        }

        foreach ($items as $uid => $item) {
            if (!isset($entityItems[$uid])) {
                /* @var $entity \SclZfCart\Entity\CartItem */
                //$entityItems[$uid] = $this->getServiceLocator()->get('SclZfCart\Entity\CartItem');
                $entityItems[$uid] = new \SclZfCart\Entity\CartItem;
            }

            $entityItems[$uid]->setUid($item['uid'])
                ->setData($item['data']);
        }

        $this->cartEntity->setItems($entityItems);

        $this->entityManager->persist($this->cartEntity);
        $this->entityManager->flush();

        return $this->cartEntity->getId();
    }

    /**
     * Garbage collect old carts.
     *
     * @param float $probability Value of 0 to 1, 1 being all the time, 0 being never
     * @param int   $lifetime    The age in hours before a cart is expired
     */
    public function collectGarbage($probability, $lifetime)
    {
        
    }
}
