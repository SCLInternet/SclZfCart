<?php

namespace SclZfCart;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\HydratorProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use SclZfCart\Hydrator\ItemHydrator;

class Module implements
    BootstrapListenerInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ControllerProviderInterface,
    HydratorProviderInterface,
    ServiceProviderInterface
{

    public function onBootstrap(EventInterface $e)
    {
        $serviceLocator = $e->getApplication()->getServiceManager();

        $this->attachCartListener($serviceLocator);

        // @todo Should be done using a more modular approach
        $this->attachDoctrineListener($serviceLocator);
    }

    private function attachCartListener($serviceLocator)
    {
        $eventManager = $serviceLocator->get('SharedEventManager');
        $listener = $serviceLocator->get('SclZfCart\Listener\CartListener');
        $eventManager->attachAggregate($listener);
    }

    private function attachDoctrineListener($serviceLocator)
    {
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $eventManager = $entityManager->getEventManager();
        $listener = $serviceLocator->get('SclZfCart\Doctrine\PriceFactoryInjectorListener');
        $eventManager->addEventListener(
            array(\Doctrine\ORM\Events::postLoad),
            $listener
        );
    }

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

    public function getHydratorConfig()
    {
        return [
            'factories' => [
                'SclZfCart\Hydrator\ItemHydrator' => function ($hm) {
                    $sm = $hm->getServiceLocator();

                    return new ItemHydrator($sm->get('scl_currency.taxed_price_factory'));
                }
            ],
        ];
    }

    public function getServiceConfig()
    {
        return include __DIR__ . '/../../config/service.config.php';
    }
}
