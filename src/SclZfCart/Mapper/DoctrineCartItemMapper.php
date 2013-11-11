<?php

namespace SclZfCart\Mapper;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfGenericMapper\Doctrine\FlushLock;
use SclZfGenericMapper\DoctrineMapper as GenericDoctrineMapper;

/**
 * Doctrine Mapper for CartItem.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class DoctrineCartItemMapper extends GenericDoctrineMapper implements
    CartItemMapperInterface
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
            new \SclZfCart\Entity\CartItem(),
            $entityManager,
            $flushLock
        );
    }
}
