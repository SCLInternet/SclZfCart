<?php

namespace SclZfCart\Storage;

use SclZfCart\Cart;
use SclZfCart\Entity\CartInterface as CartEntity;
use SclZfCart\Exception;
use SclZfCart\Hydrator\CartItemEntityHydrator;
use SclZfCart\Hydrator\CartItemHydrator;
use SclZfCart\Mapper\CartItemMapperInterface;
use SclZfCart\Mapper\CartMapperInterface;
use SclZfCart\ProvidesUidInterface;
use SclZfCart\Service\CartItemCreatorInterface;
use SclZfCart\UidItemCollection;

/**
 * Storage class for storing a cart using doctrine.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartStorage
{
    /**
     * @var CartEntity
     */
    protected $cartEntity = null;

    /**
     * @var CartMapperInterface
     */
    protected $cartMapper;

    /**
     * @var CartItemMapperInterface
     */
    protected $cartItemMapper;

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
     * 
     * @param  CartMapperInterface      $cartMapper
     * @param  CartItemMapperInterface  $cartItemMapper
     * @param  CartItemCreatorInterface $itemCreator
     * @param  CartItemHydrator         $cartItemHydrator
     * @param  CartItemEntityHydrator   $cartItemEntityHydrator
     */
    public function __construct(
        CartMapperInterface $cartMapper,
        CartItemMapperInterface $cartItemMapper,
        CartItemCreatorInterface $itemCreator,
        CartItemHydrator $cartItemHydrator,
        CartItemEntityHydrator $cartItemEntityHydrator
    ) {
        $this->cartMapper             = $cartMapper;
        $this->cartItemMapper         = $cartItemMapper;
        $this->itemCreator            = $itemCreator;
        $this->cartItemHydrator       = $cartItemHydrator;
        $this->cartItemEntityHydrator = $cartItemEntityHydrator;
    }

    /**
     * Returns the cart entity or returns a new one if one previously had not been set.
     *
     * @return Cart
     */
    protected function getCartEntity()
    {
        if (null === $this->cartEntity) {
            $this->setCartEntity($this->cartMapper->create());
        }

        return $this->cartEntity;
    }

    /**
     * Sets the cart entity
     * 
     * @param CartEntity $entity
     * @return self
     */
    protected function setCartEntity(CartEntity $entity)
    {
        $this->cartEntity = $entity;

        return $this;
    }

    /**
     * Populates a Cart object from the entities in storage.
     *
     * @param  int  $id
     * @param  Cart $cart
     * @return Cart
     * @throws CartNotFoundException
     */
    public function load($id, Cart $cart)
    {
        $cartEntity = $this->cartMapper->findById($id);

        if (!$cartEntity) {
            throw new Exception\CartNotFoundException("Cart with \"$id\" not found.");
        }

        $this->setCartEntity($cartEntity);

        $cart->clear();

        $this->loadItems($cart, $cartEntity);

        return $cart;
    }

    /**
     * Loads items from the storage into the cart
     * 
     * @param  Cart $cart
     * @return Cart
     */
    protected function loadItems(Cart $cart, CartEntity $cartEntity)
    {
        foreach ($cartEntity->getItems() as $entity) {
            $item = $this->itemCreator->create($entity->getType());

            $data = $this->cartItemEntityHydrator->extract($entity);

            $this->cartItemHydrator->hydrate($data, $item);

            $cart->add($item);
        }

        return $cart;
    }

    /**
     * Converts a Cart object into entities persists them. 
     *
     * @param  Cart $cart
     * @return int The cart identifier
     */
    public function store(Cart $cart)
    {
        $cartEntity = $this->getCartEntity();

        $cartEntity->setLastUpdated(new \DateTime());

        $this->storeItems($cart, $cartEntity);

        $this->cartMapper->save($cartEntity);

        return $cartEntity->getId();
    }

    public function storeItems(Cart $cart, CartEntity $cartEntity)
    {
        $items       = new UidItemCollection($cart->getItems());
        $entityItems = new UidItemCollection($cartEntity->getItems());

        // Remove old entities
        foreach ($entityItems->diffItems($items) as $entity) {
            $this->cartItemMapper->delete($entity);
            $entityItems->remove($entity);
        }

        // Create new entities
        foreach ($items->diffUids($entityItems) as $uid) {
            $entity = $this->cartItemMapper->create();
            $entity->setUid($uid);
            $entityItems->add($entity);
        }

        // Copy the data across
        foreach ($items->getItems() as $uid => $item) {
            $entity = $entityItems->get($uid);

            $data = $this->cartItemHydrator->extract($item);

            $this->cartItemEntityHydrator->hydrate($data, $entity);
        }

        $cartEntity->setItems($entityItems->getItems());
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
