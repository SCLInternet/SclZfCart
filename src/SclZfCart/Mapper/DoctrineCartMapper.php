<?php

namespace SclZfCart\Mapper;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfUtilities\Doctrine\FlushLock;
use SclZfUtilities\Mapper\GenericDoctrineMapper;

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
            $entityManager,
            $flushLock,
            'SclZfCart\Entity\DoctrineCart'
        );
    }
}
