<?php

namespace SclZfCart\Storage;

use SclZfCart\Cart;
use SclZfCart\Entity\Cart as CartEntity;
use SclZfCart\Exception;
use SclZfCart\Hydrator\CartItemEntityHydrator;
use SclZfCart\Hydrator\CartItemHydrator;
use SclZfCart\Mapper\CartItemMapperInterface;
use SclZfCart\Mapper\CartMapperInterface;
use SclZfCart\ProvidesUidInterface;
use SclZfCart\Service\CartItemCreatorInterface;

/**
 * Storage class for storing a cart using doctrine.
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @todo Redesign and refactor this class.
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
     * {@inheritDoc}
     *
     * @param  int  $id
     * @param  Cart $cart
     * @return void
     * @throws CartNotFoundException
     */
    public function load($id, Cart $cart)
    {
        $this->cartEntity = $this->cartMapper->findById($id);

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
            $this->cartEntity = $this->cartMapper->create();
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
     * Compares the UIDs of 2 objects which provide UIDs.
     * 
     * @param  ProvidesUidInterface $a
     * @param  ProvidesUidInterface $b
     * @return boolean
     */
    public static function uidCompare(ProvidesUidInterface $a, ProvidesUidInterface $b)
    {
        return $a->getUid() === $b->getUid();
    }

    /**
     * {@inheritDoc}
     *
     * @param  Cart $cart
     * @return int The cart identifier
     */
    public function store(Cart $cart)
    {
        $cartEntity = $this->getCartEntity();

        /*
        $items       = new UidItemCollection($cart->getItems());
        $entityItems = new UidItemCollection($cartEntity->getItems());

        $deadEntities = array_udiff($entityItems, $items, 'SclZfCart\Storage\CartStorage::uidCompare');
        $newEntities = array_udiff($items, $entityItems, 'SclZfCart\Storage\CartStorage::uidCompare');

        //*/
        // Get extracted data from the cart keyed by UID
        $items = $this->cartItemsToArray($cart);

        $entityItems = array();

        // Run through entities removing items which are not in the cart and
        // adding all others to an array of new items
        foreach ($cartEntity->getItems() as $key => $entity) {
            if (!isset($items[$entity->getUid()])) {
                $this->cartItemMapper->delete($entity);
                continue;
            }

            $entityItems[$entity->getUid()] = $entity;
        }

        // Run through the items in the cart and either update or create entity
        // items or use existing ones and hydrate them
        foreach ($items as $uid => $itemData) {
            if (!isset($entityItems[$uid])) {
                $entityItems[$uid] = $this->cartItemMapper->create();
            }

            $this->cartItemEntityHydrator->hydrate($itemData, $entityItems[$uid]);
        }
        //*/

        $cartEntity->setItems($entityItems);
        $cartEntity->setLastUpdated(new \DateTime());

        $this->cartMapper->save($cartEntity);

        return $cartEntity->getId();
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
