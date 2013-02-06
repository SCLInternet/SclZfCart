<?php

namespace SclZfCart\Storage;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfCart\Cart;
use SclZfCart\CartItem;
use SclZfCart\Entity\Cart as CartEntity;
use SclZfCart\Hydrator\CartHydrator;

/**
 * Storage class for storing a cart using doctrine.
 *
 * @author Tom Oram <tom@scl.co.uk>
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
     *
     * @return void
     */
    public function load($id, Cart $cart)
    {
        $this->cartEntity = $this->entityManager->find('SclZfCart\Entity\Cart', $id);

        if (!$this->cartEntity) {
            throw new \Exception("Cart with \"%id\" not found.");
        }

        $this->hydrator->hydrate($this->cartEntity->getItems()->toArray(), $cart);
    }

    /**
     * {@inheritDoc}
     *
     * @param Cart $cart
     *
     * @return int The cart identifier
     */
    public function store(Cart $cart)
    {
        if (null === $this->cartEntity) {
            $this->cartEntity = new CartEntity();
        }

        $this->cartEntity->setLastUpdated(new \DateTime());

        $items = $this->hydrator->extract($cart);

        var_dump (array_keys($items));

        $entityItems = array();
        foreach ($this->cartEntity->getItems() as $item) {
            $entityItems[$item->getUid()] = $item;
        }

        var_dump (array_keys($entityItems));

        foreach ($items as $key => &$item) {
            if (isset($entityItems[$key])) {
                $item->setId($entityItems[$key]->getId());
            }
        }

        $this->cartEntity->setItems($items);

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
