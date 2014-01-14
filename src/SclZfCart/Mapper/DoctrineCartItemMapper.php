<?php

namespace SclZfCart\Mapper;

use Doctrine\Common\Persistence\ObjectManager;
use SCL\Currency\TaxedPriceFactory;
use SclZfGenericMapper\DoctrineMapper as GenericDoctrineMapper;
use SclZfGenericMapper\Doctrine\FlushLock;

/**
 * Doctrine Mapper for CartItem.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class DoctrineCartItemMapper extends GenericDoctrineMapper implements
    CartItemMapperInterface
{
    /**
     * @var TaxedPriceFactory
     */
    private $priceFactory;

    /**
     * @param ObjectManager $entityManager
     * @param FlushLock     $flushLock
     */
    public function __construct(
        ObjectManager $entityManager,
        FlushLock $flushLock,
        TaxedPriceFactory $priceFactory
    ) {
        parent::__construct(
            new \SclZfCart\Entity\CartItem(),
            $entityManager,
            $flushLock
        );

        $this->priceFactory = $priceFactory;
    }

    public function create()
    {
        $item = parent::create();

        $item->setPriceFactory($this->priceFactory);

        return $item;
    }
}
