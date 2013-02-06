<?php

namespace SclZfCart\Storage;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfCart\Cart;
use SclZfCart\CartItem;
use SclZfCart\Entity\Cart as CartEntity;
use SclZfCart\Entity\CartItem as CartItemEntity;
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
    private $cart;

    /**
     * @var CartItemEntity[]
     */
    private $items = array();

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
     * @param int $id
     *
     * @return Cart
     */
    public function load($id)
    {
        $this->cart = $this->entityManager->find('SclZfCart\Entity\Cart', $id);

        if (!$this->cart) {
            throw new \Exception("Cart with \"%id\" not found.");
        }

        $items = $this->entityManager->getResource('SclZfCart\Entity\CartItem')
            ->findBy(array('cartId' => $id));

        foreach ($items as $item) {
            $this->items[$item->getUid()] = $item;
        }

        $cart = new Cart;

        $data = array(
            'cart'     => $this->cart,
            'items' => $this->cartItem
        );

        $this->hydrator->hydrate($data, $cart);

        return $cart;
    }

    /**
     * {@inheritDoc}
     *
     * @param Cart $cart
     *
     * @return void
     */
    public function store(Cart $cart)
    {
        $data = $this->hydrator->extract($cart);

        $this->cart = $data['cart'];

        foreach ($data['items'] as $key => &$item) {
            if (isset($this->items[$key])) {
                $item->setId($this->items[$key]->getId());
                $this->entityManager->persist($item);
            } else {
                $this->entityManager->remove($this->items[$key]);
            }
        }

        $this->items = $data['items'];

        $this->entityManager->flush();
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
