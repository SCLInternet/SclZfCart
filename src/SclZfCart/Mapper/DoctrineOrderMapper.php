<?php

namespace SclZfCart\Mapper;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfGenericMapper\Doctrine\FlushLock;
use SclZfGenericMapper\DoctrineMapper as GenericDoctrineMapper;
use SclZfCart\Entity\OrderInterface;

/**
 * Doctrine Mapper for Order.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class DoctrineOrderMapper extends GenericDoctrineMapper implements
    OrderMapperInterface
{
    /**
     * @param ObjectManager $entityManager
     * @param FlushLock     $flushLock
     */
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

    public function create()
    {
        $order = parent::create();
        $order->setStatus(OrderInterface::STATUS_PENDING);

        return $order;
    }
}
