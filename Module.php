<?php

namespace SclZfCart;

use SclZfCart\Storage\DoctrineStorage;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Session\Container;
use SclZfCart\Service\CartToOrderService;

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
                'SclZfCart\Hydrator\CartItemHydrator'  => 'SclZfCart\Hydrator\CartItemHydrator',
                'SclZfCart\Hydrator\CartItemEntityHydrator' => 'SclZfCart\Hydrator\CartItemEntityHydrator',

                'SclZfCart\Hydrator\OrderItemHydrator' => 'SclZfCart\Hydrator\OrderItemHydrator',
                'SclZfCart\Entity\DoctrineOrder'       => 'SclZfCart\Entity\DoctrineOrder',
                'SclZfCart\Entity\DoctrineOrderItem'   => 'SclZfCart\Entity\DoctrineOrderItem',
            ),
            'factories' => array(
                'SclZfCart\Cart'    => 'SclZfCart\Service\CartFactory',
                'SclZfCart\Session' => function ($serviceLocator) {
                    $config = $serviceLocator->get('Config');
                    return new Container($config['scl_zf_cart']['session_name']);
                },
                // @todo user the interface name
                'SclZfCart\Storage' => function ($serviceLocator) {
                    $config = $serviceLocator->get('Config');
                    return $serviceLocator->get($config['scl_zf_cart']['storage_class']);
                },
                'SclZfCart\Storage\DoctrineStorage' => function ($serviceLocator) {

                    return new DoctrineStorage(
                        $serviceLocator->get('doctrine.entitymanager.orm_default'),
                        $serviceLocator->get('SclZfCart\Service\CartItemCreatorInterface'),
                        $serviceLocator->get('SclZfCart\Hydrator\CartItemHydrator'),
                        $serviceLocator->get('SclZfCart\Hydrator\CartItemEntityHydrator')
                    );
                },
                'SclZfCart\Service\CartItemCreatorInterface' => function ($serviceLocator) {
                    return new \SclZfCart\Service\ServiceLocatorItemCreator($serviceLocator);
                },

                // Options
                'SclZfCart\Options\CartOptions' => function ($sm) {
                    $config = $sm->get('Config');
                    return new \SclZfCart\Options\CartOptions(
                        $config['scl_zf_cart']
                    );
                },

                // Mapper & Entity interfaces
                // @todo replace with aliase and avoid additional options layer.
                'SclZfCart\Entity\OrderInterface' => function ($sm) {
                    $options = $sm->get('SclZfCart\Options\CartOptions');
                    return $sm->get($options->getOrderClass());
                },
                'SclZfCart\Entity\OrderItemInterface' => function ($sm) {
                    $options = $sm->get('SclZfCart\Options\CartOptions');
                    return $sm->get($options->getOrderItemClass());
                },
                'SclZfCart\Mapper\OrderMapperInterface' => function ($sm) {
                    $options = $sm->get('SclZfCart\Options\CartOptions');
                    return $sm->get($options->getOrderMapperClass());
                },
                'SclZfCart\Mapper\OrderItemMapperInterface' => function ($sm) {
                    $options = $sm->get('SclZfCart\Options\CartOptions');
                    return $sm->get($options->getItemMapperClass());
                },

                // Mapper implementations
                // @todo append Doctrine rather than prepend
                'SclZfCart\Mapper\DoctrineOrderMapper' => function ($sm) {
                    return new \SclZfCart\Mapper\DoctrineOrderMapper(
                        $sm->get('doctrine.entitymanager.orm_default'),
                        $sm->get('SclZfUtilities\Doctrine\FlushLock')
                    );
                },
                'SclZfCart\Mapper\DoctrineOrderItemMapper' => function ($sm) {
                    return new \SclZfCart\Mapper\DoctrineOrderItemMapper(
                        $sm->get('doctrine.entitymanager.orm_default'),
                        $sm->get('SclZfUtilities\Doctrine\FlushLock')
                    );
                },

                // Services
                'SclZfCart\Service\CartToOrderServiceService' => function ($sm) {
                    return new CartToOrderService(
                        $sm->get('SclZfCart\Service\CartItemCreatorInterface'),
                        $sm->get('SclZfCart\Hydrator\CartItemHydrator'),
                        $sm->get('SclZfCartOrder\Hydrator\OrderItemHydrator'),
                        $sm->get('SclZfCartOrder\Mapper\OrderItemMapperInterface')
                    );
                },
            ),
        );
    }
}
