<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'SclZfCart\Controller\Checkout' => 'SclZfCart\Controller\CheckoutController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'cart' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/cart',
                    'defaults' => array(
                        'controller' => 'SclZfCart\Controller\Checkout',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    //'view' => array(
                    //    'type'    => 'literal',
                    //    'options' => array(
                    //        'route'    => '/view',
                    //        'defaults' => array(
                    //            'controller' => 'SclZfCart\Controller\Checkout',
                    //            'action'     => 'index',
                    //        ),
                    //    ),
                    //),
                ), 
            ),
        ),
    ),

    'scl_zf_cart' => array(
        'session_name'  => 'SclZfCart',
        'storage_class' => 'SclZfCart\Storage\DoctrineStorage',
    ),

    // @todo Move to .dist config file
    'doctrine' => array(
        'driver' => array(
            'sclzfcart_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/xml/doctrine-entities'
            ),

            'orm_default' => array(
                'drivers' => array(
                    'SclZfCart\Entity'  => 'sclzfcart_entity'
                )
            )
        )
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'SclZfCart\Controller' => __DIR__ . '/../view',
        ),
    ),
);
