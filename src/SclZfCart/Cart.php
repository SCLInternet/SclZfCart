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
     * {@inheritDoc
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
     * @param ProductInterface $item
     */
    public function add(ProductInterface $item)
    {
        
    }

    /**
     * Removes an item from the cart.
     *
     * @param ProductInterface $item
     */
    public function remove(ProductInterface $item)
    {
        
    }

    /**
     * Fetches a list of all the items in the cart.
     *
     * @return CartItem[]
     */
    public function getItems()
    {
        
    }
}
