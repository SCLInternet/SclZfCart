<?php

namespace SclZfCart;

return [
    'controllers' => [
        'invokables' => [
            'SclZfCart\Controller\Cart'     => 'SclZfCart\Controller\CartController',
            'SclZfCart\Controller\Checkout' => 'SclZfCart\Controller\CheckoutController',
        ],
    ],

    'router' => [
        'routes' => [
            'cart' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/cart',
                    'defaults' => [
                        'controller' => 'SclZfCart\Controller\Cart',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'remove' => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/remove/:item',
                            'defaults' => [
                                'controller' => 'SclZfCart\Controller\Cart',
                                'action'     => 'removeItem',
                            ],
                        ],
                    ],
                    'checkout' => [
                        'type'    => 'literal',
                        'options' => [
                            'route'    => '/checkout',
                            'defaults' => [
                                'controller' => 'SclZfCart\Controller\Checkout',
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes'  => [
                            'process' => [
                                'type'    => 'literal',
                                'options' => [
                                    'route'    => '/process',
                                    'defaults' => [
                                        'controller' => 'SclZfCart\Controller\Checkout',
                                        'action'     => 'process',
                                    ],
                                ],
                            ],
                            'complete' => [
                                'type'    => 'literal',
                                'options' => [
                                    'route'    => '/complete',
                                    'defaults' => [
                                        'controller' => 'SclZfCart\Controller\Checkout',
                                        'action'     => 'completed',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'scl_zf_cart' => [
        /**
         * The name of the session container for storing cart info.
         */
        'session_name'       => 'SclZfCart',

        /**
         * The route to redirect a user to if then need to register/login.
         */
        'login_route'        => 'zfcuser/login',
    ],

    'asset_manager' => [
        'resolver_configs' => [
            'map' => [
                'css/scl-zf-cart/cart.css' => __DIR__ . '/../public/less/cart.less',
            ],
        ],
        'filters' => [
            'css/scl-zf-cart/cart.css' => [
                [
                    'filter' => 'LessphpFilter',
                ],
            ],
        ],
    ],

    // @todo Move to .dist config file
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/xml/doctrine-entities'
            ],
            'orm_default' => [
                'drivers' => [
                    // Added trailing backslash to avoid partial matches
                    __NAMESPACE__ . '\\' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],

    'controller_plugins' => [
        'invokables' => [
            'getCart' => 'SclZfCart\Controller\Plugin\Cart',
        ],
    ],

    'view_helpers' => [
        'invokables' => [
            'getCart' => 'SclZfCart\View\Helper\Cart',
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'SclZfCart\Controller' => __DIR__ . '/../view',
        ],
    ],
];
