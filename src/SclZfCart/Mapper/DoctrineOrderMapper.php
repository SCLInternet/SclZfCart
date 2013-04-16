<?php

namespace SclZfCart\Mapper;

use Doctrine\ORM\EntityManager;
use SclZfUtilities\Doctrine\FlushLock;
use SclZfUtilities\Mapper\GenericDoctrineMapper;
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
     * 
     * @param EntityManager $entityManager
     * @
     */
    public function __construct(
        EntityManager $entityManager,
        FlushLock $flushLock
    ) {
        parent::__construct(
            $entityManager,
            $flushLock,
            'SclZfCart\Entity\DoctrineOrder'
        );
    }

    public function create()
    {
        $order = parent::create();
        $order->setStatus(OrderInterface::STATUS_PENDING);
        return $order;
	}
}
