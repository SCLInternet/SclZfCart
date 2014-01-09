<?php

namespace SclZfCart\Mapper;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfCart\Entity\Order;
use SclZfCart\Entity\OrderItem;
use SclZfGenericMapper\DoctrineMapper as GenericDoctrineMapper;
use SclZfGenericMapper\Doctrine\FlushLock;

class DoctrineOrderItemMapper extends GenericDoctrineMapper implements
    OrderItemMapperInterface
{
    public function __construct(
        ObjectManager $entityManager,
        FlushLock $flushLock
    ) {
        parent::__construct(
            new \SclZfCart\Entity\OrderItem(),
            $entityManager,
            $flushLock
        );
    }

    /**
     * @return OrderItem[]|null
     */
    public function findAllForOrder(Order $order)
    {
         return parent::fetchBy(['order' => $order]);
    }
}
