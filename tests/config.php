<?php

namespace SclZfCart;

return [
    'service_manager' => [
        'aliases' => [
            'SclZfCart\Customer\CustomerLocatorInterface' => 'test_customer_locator',
        ],
        'invokables' => [
            'test_customer_locator' => 'SclZfCartTests\TestAssets\TestCustomerLocator',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/../data/xml/doctrine-entities.dist/'
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\\' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                'params' => [
                    'path'=> __DIR__ . '/test.db',
                ],
            ],
        ],
    ],
];
