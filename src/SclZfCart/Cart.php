<?php

namespace SclZfCart;

use Zend\Cache\Storage\Event;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * The shopping cart
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Cart implements
    EventManagerAwareInterface,
    ServiceLocatorAwareInterface
{
    /**
     * The service locator.
     *
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * The event manager.
     *
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     * The items in the cart
     *
     * @var CartItem[]
     */
    private $items = array();

    /**
     * {@inheritDoc}
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * {@inheritDoc}
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * {@inheritDoc}
     *
     * @param EventManagerInterface $eventManager
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setEventClass('SclZfCart\CartEvent');
        $this->eventManager = $eventManager;
    }

    /**
     * {@inheritDoc}
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * Adds an item to the cart.
     *
     * @param CartItemInterface $product
     * @param int               $quantity
     *
     * @param void
     */
    public function add(CartItemInterface $item)
    {
        $uid = $item->getUid();

        if (isset($this->items[$uid])) {
            $quantity = $this->items[$uid]->getQuantity() + $item->getQuantity();
            $this->items[$uid]->setQuantity($quantity);
            return;
        }

        $this->items[$uid] = $item;
    }

    /**
     * Removes an item from the cart.
     *
     * @param CartItemInterface|string $item
     */
    public function remove($item)
    {
        if ($item instanceof CartItemInterface) {
            unset($this->items[$item->getUid()]);
        } else {
            unset($this->items[(string) $item]);
        }
    }

    /**
     * Returns the item by uid.
     *
     * @param string $uid
     * @return CartItemInterface
     */
    public function getItem($uid)
    {
        if (!isset($this->items[$uid])) {
            return null;
        }

        return $this->items[$uid];
    }

    /**
     * Empties the contents of the cart.
     *
     * @return void
     */
    public function clear()
    {
        $this->items = array();
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
