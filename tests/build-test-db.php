<?php

require __DIR__ . '/Bootstrap.php';

$em = \TestBootstrap::getEntityManager();

$tool = new \Doctrine\ORM\Tools\SchemaTool($em);

$classes = [
    $em->getClassMetadata('SclZfCart\Entity\Cart'),
    $em->getClassMetadata('SclZfCart\Entity\CartItem'),
    $em->getClassMetadata('SclZfCart\Entity\Order'),
    $em->getClassMetadata('SclZfCart\Entity\OrderItem'),
];

$tool->updateSchema($classes);
