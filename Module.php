<?php

namespace SclZfCart;

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
    const DEFAULT_PROCESS_PREFERENCE  = 0;
    const DEFAULT_COMPLETE_PREFERENCE = 0;

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

        // @todo Use shared event manager and switch to fetching the event manager & ServiceLocator from the event.
        // @todo Move the events out of this class

        // Default process order event
        $eventManager->attach(
            CartEvent::EVENT_PROCESS,
            function (CartEvent $event) use ($eventManager) {
                $order = $event->getTarget();

                $eventManager->trigger(CartEvent::EVENT_COMPLETE, $order);

                return new \SclZfUtilities\Model\Route(
                    'cart/checkout/complete',
                    array('id' => $order->getId())
                );
            },
            self::DEFAULT_PROCESS_PREFERENCE
        );

        // Default complete order event
        $eventManager->attach(
            CartEvent::EVENT_COMPLETE,
            function (CartEvent $event) use ($serviceLocator) {
                $order = $event->getTarget();
                $orderService = $serviceLocator->get('SclZfCart\Service\OrderCompletionService');
                $orderService->complete($order);
            }
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
                'SclZfCart\CartItem'                => false,
                'SclZfCart\Entity\DoctrineCartItem' => false,
            ),
            'aliases' => array(
                // Entities
                'SclZfCart\Entity\CartInterface'            => 'SclZfCart\Entity\DoctrineCart',
                'SclZfCart\Entity\CartItemInterface'        => 'SclZfCart\Entity\DoctrineCartItem',
                'SclZfCart\Entity\OrderInterface'           => 'SclZfCart\Entity\DoctrineOrder',
                'SclZfCart\Entity\OrderItemInterface'       => 'SclZfCart\Entity\DoctrineOrderItem',
                // Mappers
                'SclZfCart\Mapper\CartMapperInterface'      => 'SclZfCart\Mapper\DoctrineCartMapper',
                'SclZfCart\Mapper\CartItemMapperInterface'  => 'SclZfCart\Mapper\DoctrineCartItemMapper',
                'SclZfCart\Mapper\OrderMapperInterface'     => 'SclZfCart\Mapper\DoctrineOrderMapper',
                'SclZfCart\Mapper\OrderItemMapperInterface' => 'SclZfCart\Mapper\DoctrineOrderItemMapper',
            ),
            'invokables' => array(
                'SclZfCart\CartObject'                      => 'SclZfCart\Cart',
                'SclZfCart\CartItem'                        => 'SclZfCart\CartItem',
                'SclZfCart\Entity\CartItem'                 => 'SclZfCart\Entity\CartItem',
                'SclZfCart\Form\Cart'                       => 'SclZfCart\Form\Cart',
                // Hydrators
                'SclZfCart\Hydrator\CartItemHydrator'       => 'SclZfCart\Hydrator\CartItemHydrator',
                'SclZfCart\Hydrator\CartItemEntityHydrator' => 'SclZfCart\Hydrator\CartItemEntityHydrator',
                'SclZfCart\Hydrator\OrderItemHydrator'      => 'SclZfCart\Hydrator\OrderItemHydrator',
                // Entities
                'SclZfCart\Entity\DoctrineCart'             => 'SclZfCart\Entity\DoctrineCart',
                'SclZfCart\Entity\DoctrineCartItem'         => 'SclZfCart\Entity\DoctrineCartItem',
                'SclZfCart\Entity\DoctrineOrder'            => 'SclZfCart\Entity\DoctrineOrder',
                'SclZfCart\Entity\DoctrineOrderItem'        => 'SclZfCart\Entity\DoctrineOrderItem',
            ),
            'factories' => array(
                'SclZfCart\Cart'    => 'SclZfCart\Service\CartFactory',
                'SclZfCart\Session' => function ($serviceLocator) {
                    $config = $serviceLocator->get('Config');
                    return new Container($config['scl_zf_cart']['session_name']);
                },
                'SclZfCart\Storage\CartStorage' => function ($serviceLocator) {
                    return new \SclZfCart\Storage\CartStorage(
                        $serviceLocator->get('SclZfCart\Mapper\CartMapperInterface'),
                        $serviceLocator->get('SclZfCart\Mapper\CartItemMapperInterface'),
                        $serviceLocator->get('SclZfCart\Service\CartItemCreatorInterface'),
                        $serviceLocator->get('SclZfCart\Hydrator\CartItemHydrator'),
                        $serviceLocator->get('SclZfCart\Hydrator\CartItemEntityHydrator')
                    );
                },
                'SclZfCart\Service\CartItemCreatorInterface' => function ($serviceLocator) {
                    return new \SclZfCart\Service\ServiceLocatorItemCreator($serviceLocator);
                },

                // Options
                /*
                'SclZfCart\Options\CartOptions' => function ($sm) {
                    $config = $sm->get('Config');
                    return new \SclZfCart\Options\CartOptions(
                        $config['scl_zf_cart']
                    );
                },
                */

                // Mapper implementations
                // @todo append Doctrine rather than prepend
                'SclZfCart\Mapper\DoctrineCartMapper' => function ($sm) {
                    return new \SclZfCart\Mapper\DoctrineCartMapper(
                        $sm->get('doctrine.entitymanager.orm_default'),
                        $sm->get('SclZfUtilities\Doctrine\FlushLock')
                    );
                },
                'SclZfCart\Mapper\DoctrineCartItemMapper' => function ($sm) {
                    return new \SclZfCart\Mapper\DoctrineCartItemMapper(
                        $sm->get('doctrine.entitymanager.orm_default'),
                        $sm->get('SclZfUtilities\Doctrine\FlushLock')
                    );
                },
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
                'SclZfCart\Service\CartToOrderService' => function ($sm) {
                    return new \SclZfCart\Service\CartToOrderService(
                        $sm->get('SclZfCart\Service\CartItemCreatorInterface'),
                        $sm->get('SclZfCart\Hydrator\CartItemHydrator'),
                        $sm->get('SclZfCart\Hydrator\OrderItemHydrator'),
                        $sm->get('SclZfCart\Mapper\OrderItemMapperInterface')
                    );
                },
                'SclZfCart\Service\OrderCompletionService' => function ($sm) {
                    return new \SclZfCart\Service\OrderCompletionService(
                        $sm->get('SclZfCart\Mapper\OrderMapperInterface')
                    );
                }
            ),
        );
    }
}
