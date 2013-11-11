<?php

namespace SclZfCart;

return [
    'shared' => [
        'SclZfCart\CartItem'                => false,
        'SclZfCart\Entity\DoctrineCartItem' => false,
    ],

    'aliases' => [
//        'SclZfCart\Customer\CustomerLocatorInterface' => 'SclZfCart\Customer\ZfcUserCustomerLocator',

        /*
         * Entities
         */

        'SclZfCart\Entity\CartInterface'             => 'SclZfCart\Entity\DoctrineCart',
        'SclZfCart\Entity\CartItemInterface'         => 'SclZfCart\Entity\DoctrineCartItem',
        'SclZfCart\Entity\OrderInterface'            => 'SclZfCart\Entity\DoctrineOrder',
        'SclZfCart\Entity\OrderItemInterface'        => 'SclZfCart\Entity\DoctrineOrderItem',

        /*
         * Mappers
         */

        'SclZfCart\Mapper\CartMapperInterface'       => 'SclZfCart\Mapper\DoctrineCartMapper',
        'SclZfCart\Mapper\CartItemMapperInterface'   => 'SclZfCart\Mapper\DoctrineCartItemMapper',
        'SclZfCart\Mapper\OrderMapperInterface'      => 'SclZfCart\Mapper\DoctrineOrderMapper',
        'SclZfCart\Mapper\OrderItemMapperInterface'  => 'SclZfCart\Mapper\DoctrineOrderItemMapper',
    ],

    'invokables' => [
        'SclZfCart\CartObject'                       => 'SclZfCart\Cart',
        'SclZfCart\CartItem'                         => 'SclZfCart\CartItem',
        'SclZfCart\Entity\CartItem'                  => 'SclZfCart\Entity\CartItem',
        'SclZfCart\Form\Cart'                        => 'SclZfCart\Form\Cart',

         /*
          * Hydrators
          */

        'SclZfCart\Hydrator\ItemHydrator'            => 'SclZfCart\Hydrator\ItemHydrator',

        /*
         * Entities
         */

        'SclZfCart\Entity\DoctrineCart'              => 'SclZfCart\Entity\DoctrineCart',
        'SclZfCart\Entity\DoctrineCartItem'          => 'SclZfCart\Entity\DoctrineCartItem',
        'SclZfCart\Entity\DoctrineOrder'             => 'SclZfCart\Entity\DoctrineOrder',
        'SclZfCart\Entity\DoctrineOrderItem'         => 'SclZfCart\Entity\DoctrineOrderItem',
    ],

    'factories' => [
        'SclZfCart\Cart'    => 'SclZfCart\Service\CartFactory',


        'SclZfCart\Session' => function ($serviceLocator) {
            $config = $serviceLocator->get('Config');
            return new \Zend\Session\Container($config['scl_zf_cart']['session_name']);
        },

        'SclZfCart\Storage\CartStorage' => function ($serviceLocator) {
            return new \SclZfCart\Storage\CartStorage(
                $serviceLocator->get('SclZfCart\Mapper\CartMapperInterface'),
                $serviceLocator->get('SclZfCart\Mapper\CartItemMapperInterface'),
                $serviceLocator->get('SclZfCart\Service\CartItemCreatorInterface'),
                $serviceLocator->get('SclZfCart\Hydrator\ItemHydrator')
            );
        },

        'SclZfCart\Service\CartItemCreatorInterface' => function ($serviceLocator) {
            return new \SclZfCart\Service\ServiceLocatorItemCreator($serviceLocator);
        },

        'SclZfCart\Customer\ZfcUserCustomerLocator' => function ($sm) {
            return new \SclZfCart\Customer\ZfcUserCustomerLocator(
                $sm->get('zfcuser_auth_service')
            );
        },

        // @todo Move to a factory class
        'SclZfCart\Listener\CartListener' => function ($sm) {
            $cart = $sm->get('SclZfCart\Cart');
            $config = $sm->get('Config')['scl_zf_cart'];

            return new \SclZfCart\Listener\CartListener(
                $cart->getEventManager(),
                $sm->get('SclZfCart\Customer\CustomerLocatorInterface'),
                $sm->get('SclZfCart\Service\OrderCompletionService'),
                $config['login_route']
            );
        },
        /*
         * Options

        'SclZfCart\Options\CartOptions' => function ($sm) {
            $config = $sm->get('Config');
            return new \SclZfCart\Options\CartOptions(
                $config['scl_zf_cart']
            );
        },
        */

        /*
         * Mapper implementations
         */

        'SclZfCart\Mapper\DoctrineCartMapper' => function ($sm) {
            return new \SclZfCart\Mapper\DoctrineCartMapper(
                $sm->get('doctrine.entitymanager.orm_default'),
                $sm->get('SclZfGenericMapper\Doctrine\FlushLock')
            );
        },

        'SclZfCart\Mapper\DoctrineCartItemMapper' => function ($sm) {
            return new \SclZfCart\Mapper\DoctrineCartItemMapper(
                $sm->get('doctrine.entitymanager.orm_default'),
                $sm->get('SclZfGenericMapper\Doctrine\FlushLock')
            );
        },

        'SclZfCart\Mapper\DoctrineOrderMapper' => function ($sm) {
            return new \SclZfCart\Mapper\DoctrineOrderMapper(
                $sm->get('doctrine.entitymanager.orm_default'),
                $sm->get('SclZfGenericMapper\Doctrine\FlushLock')
            );
        },

        'SclZfCart\Mapper\DoctrineOrderItemMapper' => function ($sm) {
            return new \SclZfCart\Mapper\DoctrineOrderItemMapper(
                $sm->get('doctrine.entitymanager.orm_default'),
                $sm->get('SclZfGenericMapper\Doctrine\FlushLock')
            );
        },

        /*
         * Services
         */

        'SclZfCart\Service\CartToOrderService' => function ($sm) {
            return new \SclZfCart\Service\CartToOrderService(
                $sm->get('SclZfCart\Service\CartItemCreatorInterface'),
                $sm->get('SclZfCart\Hydrator\ItemHydrator'),
                $sm->get('SclZfCart\Mapper\OrderItemMapperInterface')
            );
        },

        'SclZfCart\Service\OrderCompletionService' => function ($sm) {
            return new \SclZfCart\Service\OrderCompletionService(
                $sm->get('SclZfCart\Mapper\OrderMapperInterface')
            );
        }
    ],
];
