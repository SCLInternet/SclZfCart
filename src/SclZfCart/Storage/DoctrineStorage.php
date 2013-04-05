<?php

namespace SclZfCart\Storage;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfCart\Cart;
use SclZfCart\CartItemInterface;
use SclZfCart\Entity\Cart as CartEntity;
use SclZfCart\Entity\CartItem as CartItemEntity;
use SclZfCart\Hydrator\CartItemEntityHydrator;
use SclZfCart\Hydrator\CartItemHydrator;
use SclZfCart\Exception;
use SclZfCart\Service\CartItemCreatorInterface;

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
    protected $cartEntity = null;

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var CartItemCreatorInterface
     */
    protected $itemCreator;

    /**
     * @var CartItemHydrator
     */
    protected $cartItemHydrator;

    /**
     * @var CartItemEntityHydrator
     */
    protected $cartItemEntityHydrator;

    /**
     * @param ObjectManager $entityManager
     */
    public function __construct(
        ObjectManager $entityManager,
        CartItemCreatorInterface $itemCreator,
        CartItemHydrator $cartItemHydrator,
        CartItemEntityHydrator $cartItemEntityHydrator
    ) {
        $this->entityManager          = $entityManager;
        $this->itemCreator            = $itemCreator;
        $this->cartItemHydrator       = $cartItemHydrator;
        $this->cartItemEntityHydrator = $cartItemEntityHydrator;
    }

    /**
     * Load the cart from the database.
     *
     * @param  int $id
     * @return CartEntity 
     */
    protected function loadCartById($id)
    {
        return $this->entityManager->find('SclZfCart\Entity\Cart', $id);
    }

    /**
     * {@inheritDoc}
     *
     * @param  int  $id
     * @param  Cart $cart
     * @return void
     * @throws CartNotFoundException
     */
    public function load($id, Cart $cart)
    {
        $this->cartEntity = $this->loadCartById($id);

        if (!$this->cartEntity) {
            throw new Exception\CartNotFoundException("Cart with \"$id\" not found.");
        }

        $cart->clear();

        foreach ($this->cartEntity->getItems() as $entity) {
            $item = $this->itemCreator->create($entity->getType());

            $data = $this->cartItemEntityHydrator->extract($entity);

            $this->cartItemHydrator->hydrate($data, $item);

            $cart->add($item);
        }
    }

    /**
     * Returns the cart entity or returns a new one if one previously had not been set.
     *
     * @return Cart
     * @todo Maybe move this back into store()
     */
    protected function getCartEntity()
    {
        if (null === $this->cartEntity) {
            $this->cartEntity = new CartEntity();
        }

        return $this->cartEntity;
    }

    /**
     * Converts the cart items to an array of useful information
     *
     * @param  Cart $cart
     * @return array
     */
    protected function cartItemsToArray(Cart $cart)
    {
        $data = array();

        /* @var $item \SclZfCart\CartItemInterface */
        foreach ($cart->getItems() as $item) {
            $data[$item->getUid()] = $this->cartItemHydrator->extract($item);
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     *
     * @param  Cart $cart
     * @return int The cart identifier
     */
    public function store(Cart $cart)
    {
        $this->getCartEntity();

        $this->cartEntity->setLastUpdated(new \DateTime());

        $items = $this->cartItemsToArray($cart);

        $entityItems = array();

        foreach ($this->cartEntity->getItems() as $key => $entity) {
            if (!isset($items[$entity->getUid()])) {
                $this->entityManager->remove($entity);
                continue;
            }

            $entityItems[$entity->getUid()] = $entity;
        }

        foreach ($items as $uid => $itemData) {
            if (!isset($entityItems[$uid])) {
                /* @var $entity CartItemEntity */
                //$entityItems[$uid] = $this->getServiceLocator()->get('SclZfCart\Entity\CartItem');
                $entityItems[$uid] = new CartItemEntity();
            }

            $this->cartItemEntityHydrator->hydrate($itemData, $entityItems[$uid]);
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
