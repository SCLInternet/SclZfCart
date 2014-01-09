<?php

namespace SclZfCart\Mapper;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfGenericMapper\Doctrine\FlushLock;
use SclZfGenericMapper\DoctrineMapper as GenericDoctrineMapper;
use SclZfCart\Entity\Order;

class DoctrineOrderMapper extends GenericDoctrineMapper implements
    OrderMapperInterface
{
    public function __construct(
        ObjectManager $entityManager,
        FlushLock $flushLock
    ) {
        parent::__construct(
            new \SclZfCart\Entity\Order(),
            $entityManager,
            $flushLock
        );
    }

    /**
     * @return Order
     */
    public function create()
    {
        $order = parent::create();
        $order->setStatus(Order::STATUS_PENDING);

        return $order;
    }
}
