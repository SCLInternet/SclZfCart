<?php

return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'SclZfGenericMapper',
        'SCL\ZF2\Currency',
        'SclZfCart',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            __DIR__ . '/config.php',
        ),
        'module_paths' => array(
            __DIR__ . '/../vendor',
            __DIR__ . '/../..',
        ),
    ),
);
