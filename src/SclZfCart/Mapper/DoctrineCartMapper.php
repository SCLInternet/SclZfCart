<?php

namespace SclZfCart\Mapper;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfGenericMapper\Doctrine\FlushLock;
use SclZfGenericMapper\DoctrineMapper as GenericDoctrineMapper;

/**
 * Doctrine Mapper for Cart.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class DoctrineCartMapper extends GenericDoctrineMapper implements
    CartMapperInterface
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
            new \SclZfCart\Entity\Cart(),
            $entityManager,
            $flushLock
        );
    }
}
