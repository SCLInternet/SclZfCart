<?php

namespace SclZfCart\Service;

use SclZfCart\Cart;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for creating the {@see Cart} object. 
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return Cart
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $session \Zend\Session\Container */
        $session = $serviceLocator->get('SclZfCart\Session');

        $cart = $session->cart;

        if (!$cart instanceof Cart) {
            $session->cart = new Cart();
            $cart = $session->cart;
        }

        return $session->cart;
    }
}
