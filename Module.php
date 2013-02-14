<?php

namespace SclZfCart;

use SclZfCart\Hydrator\CartHydrator;
use SclZfCart\Storage\DoctrineStorage;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Session\Container;

/**
 * This module contains an extensible shopping cart solution.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Module implements
    BootstrapListenerInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     *
     * @param EventInterface $e
     */
    public function onBootstrap(EventInterface $e)
    {
        $serviceLocator = $e->getApplication()->getServiceManager();
        /* @var $cart \SclZfCart\Cart */
        $cart = $serviceLocator->get('SclZfCart\Cart');
        $eventManager = $cart->getEventManager();

        $eventManager->attach(
            CartEvent::EVENT_COMPLETE,
            array('SclZfCart\Listener\CartListener', 'completeOrder')
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return array(
            'shared' => array(
                'SclZfCart\CartItem'        => false,
                'SclZfCart\Entity\CartItem' => false,
            ),
            'invokables' => array(
                'SclZfCart\CartItem'                   => 'SclZfCart\CartItem',
                'SclZfCart\Entity\CartItem'            => 'SclZfCart\Entity\CartItem',
                'SclZfCart\Form\Cart'                  => 'SclZfCart\Form\Cart',
                'SclZfCart\Storage\CartItemSerializer' => 'SclZfCart\Storage\CartItemSerializer',
            ),
            'factories' => array(
                'SclZfCart\Cart'    => 'SclZfCart\Service\CartFactory',
                'SclZfCart\Session' => function ($serviceLocator) {
                    $config = $serviceLocator->get('Config');
                    return new Container($config['scl_zf_cart']['session_name']);
                },
                'SclZfCart\Storage' => function ($serviceLocator) {
                    $config = $serviceLocator->get('Config');
                    return $serviceLocator->get($config['scl_zf_cart']['storage_class']);
                },
                'SclZfCart\Storage\DoctrineStorage' => function ($serviceLocator) {
                    $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
                    $hydrator = $serviceLocator->get('SclZfCart\Hydrator\CartHydrator');
                    return new DoctrineStorage($entityManager, $hydrator);
                },
                'SclZfCart\Hydrator\CartHydrator' => function ($serviceLocator) {
                    $serializer = $serviceLocator->get('SclZfCart\Storage\CartItemSerializer');
                    return new CartHydrator($serializer);
                },
            ),
        );
    }
}
