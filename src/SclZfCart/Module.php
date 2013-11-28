<?php

namespace SclZfCart;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * This module contains an extensible shopping cart solution.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Module implements
    BootstrapListenerInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ControllerProviderInterface,
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

        $eventManager = $serviceLocator->get('SharedEventManager');

        $listener = $serviceLocator->get('SclZfCart\Listener\CartListener');

        $eventManager->attachAggregate($listener);
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                'SclZfCart\Controller\Checkout' => function ($cm) {
                    $sm = $cm->getServiceLocator();

                    return new \SclZfCart\Controller\CheckoutController(
                        $sm->get('SclZfCart\Service\CartToOrderService'),
                        $sm->get('SclZfCart\Mapper\OrderMapperInterface')
                    );
                },
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return include __DIR__ . '/../../config/service.config.php';
    }
}
