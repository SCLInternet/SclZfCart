<?php

namespace SclZfCart;

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
     * The event manager.
     *
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * The service locator.
     *
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * The items in the cart
     *
     * @var CartItemInterface[]
     */
    protected $items = array();

    /**
     * {@inheritDoc}
     *
     * @param EventManagerInterface $eventManager
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(
            array(
                __CLASS__,
                get_called_class(),
            )
        );

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
     * {@inheritDoc}
     *
     * The ServiceLocator is require in the event listeners.
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return self
     * @todo Maybe not needed now
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * The ServiceLocator is require in the event listeners.
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
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
     * @return CartItemInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }
}
