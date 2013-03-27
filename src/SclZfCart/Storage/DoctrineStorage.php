<?php

namespace SclZfCart\Storage;

use SclZfCart\Entity\CartItem;

use Zend\ServiceManager\ServiceLocatorInterface;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfCart\Cart;
use SclZfCart\CartItemInterface;
use SclZfCart\Entity\Cart as CartEntity;
use SclZfCart\Entity\CartItem as CartItemEntity;
use SclZfCart\Exception;

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
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;


    /**
     * @param ObjectManager $entityManager
     */
    public function __construct(
        ObjectManager $entityManager,
        ServiceLocatorInterface $serviceLocator
    ) {
        $this->entityManager = $entityManager;
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Converts the cart items to an array of useful information
     * @param  Cart $cart
     * @return array
     * @todo type is a service name so is get_class the right way to acheive this? Maybe use a static member?
     */
    protected function cartItemsToArray(Cart $cart)
    {
        $data = array();

        /* @var $item \SclZfCart\CartItemInterface */
        foreach ($cart->getItems() as $item) {
            $data[$item->getUid()] = $this->extractCartItem($item);
        }

        return $data;
    }

    /**
     * Extract data from a CartItem object
     *
     * @param  CartItemInterface $item
     * @return array
     */
    protected function extractCartItem(CartItemInterface $item)
    {
        return array(
            'uid'      => $item->getUid(),
            'type'     => get_class($item),
            'quantity' => $item->getQuantity(),
            'data'     => $item->serialize(),
        );
    }

    /**
     * Hydrates a cart item.
     *
     * @param  CartItemInterface $item
     * @param  array             $data
     * @throws InvalidArguementException
     */
    protected function hydrateCartItem(CartItemInterface $item, array $data)
    {
        if (!$item instanceof $data['type']) {
            // @todo should be DomainException
            throw new Exception\InvalidArgumentException(
                $data['type'],
                $item,
                __METHOD__,
                __LINE__
            );
        }

        $item->setUid($data['uid'])
            ->setQuantity($data['quantity']);

        $item->unserialize($data['data']);
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
            $item = $this->serviceLocator->get($entity->getType());

            $data = $this->extractCartItemEntity($entity);

            $this->hydrateCartItem($item, $data);

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
     * Extracts the data from CartItem entity
     *
     * @param  CartItemEntity $entity
     * @return array
     */
    protected function extractCartItemEntity(CartItemEntity $entity)
    {
        return array(
            'uid'      => $entity->getUid(),
            'quantity' => $entity->getQuantity(),
            'type'     => $entity->getType(),
            'data'     => $entity->getData(),
        );
    }

    /**
     * Hydrates the CartItem entity
     *
     * @param  CartItemEntity $cartItemEntity
     * @param  array          $data
     * @return void
     */
    protected function hydrateCartItemEntity(CartItemEntity $entity, array $data)
    {
        $entity->setUid($data['uid'])
            ->setQuantity($data['quantity'])
            ->setType($data['type'])
            ->setData($data['data']);
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

            $this->hydrateCartItemEntity($entityItems[$uid], $itemData);
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
