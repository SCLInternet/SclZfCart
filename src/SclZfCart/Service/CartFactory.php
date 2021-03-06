<?php

namespace SclZfCart\Service;

use SclZfCart\Cart;
use Zend\Mvc\MvcEvent;
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
        $cart = $serviceLocator->get('SclZfCart\CartObject');

        /* @var $storage \SclZfCart\Storage\StorageInterface */
        $storage = $serviceLocator->get('SclZfCart\Storage\CartStorage');

        /* @var $session \Zend\Session\Container */
        $session = $serviceLocator->get('SclZfCart\Session');

        if ($session->cartId) {
            $storage->load($session->cartId, $cart);
        }

        /* @var $eventManager \Zend\Mvc\Application */
        $application = $serviceLocator->get('Application');

        $eventManager = $application->getEventManager();

        $eventManager->attach(
            MvcEvent::EVENT_FINISH,
            function (MvcEvent $event) use ($session, $storage, $cart) {
                $session->cartId = $storage->store($cart);
            }
        );

        return $cart;
    }
}
