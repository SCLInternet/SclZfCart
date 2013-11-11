<?php

namespace SclZfCart\Mapper;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfCart\Entity\OrderInterface;
use SclZfGenericMapper\Doctrine\FlushLock;
use SclZfGenericMapper\DoctrineMapper as GenericDoctrineMapper;

/**
 * Doctrine Mapper for OrderItem.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class DoctrineOrderItemMapper extends GenericDoctrineMapper implements
    OrderItemMapperInterface
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
            new \SclZfCart\Entity\OrderItem(),
            $entityManager,
            $flushLock
        );
    }

    /**
     * {@inheritDoc}
     *
     * @param  OrderInterface
     * @return OrderItemInterface[]|null
     */
    public function findAllForOrder(OrderInterface $order)
    {
         return parent::fetchBy(['order' => $order]);
    }
}
