<?php

namespace SclZfCart;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * The shopping cart
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Cart implements ServiceLocatorAwareInterface
{
    /**
     * The service locator.
     *
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * The items in the cart
     *
     * @var CartItem[]
     */
    private $items = array();

    /**
     * {@inheritDoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Adds an item to the cart.
     *
     * @param ProductInterface $product
     * @param int              $quantity
     *
     * @param boolean True if the item was added to the cart
     */
    public function add(ProductInterface $product, $quantity = 1)
    {
        $uid = $product->getUid();

        if (isset($this->items[$uid])) {
            return $this->items[$uid]->add((int) $quantity);
        }

        $cartItem = $this->getServiceLocator()->get('SclZfCart\CartItem');
        $cartItem->setProduct($product);

        $cartItem->setQuantity($quantity);

        $this->items[$product->getUid()] = $cartItem;

        return true;
    }

    /**
     * Removes an item from the cart.
     *
     * @param ProductInterface $item
     */
    public function remove(ProductInterface $product)
    {
        unset($this->items[$product->getUid()]);
    }

    /**
     * Fetches a list of all the items in the cart.
     *
     * @return CartItem[]
     */
    public function getItems()
    {
        return $this->items;
    }
}
