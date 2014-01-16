<?php

namespace SclZfCart\Mapper;

use Doctrine\Common\Persistence\ObjectManager;
use SclZfCart\Entity\Order;
use SclZfCart\Entity\OrderItem;
use SclZfGenericMapper\DoctrineMapper as GenericDoctrineMapper;
use SclZfGenericMapper\Doctrine\FlushLock;
use SCL\Currency\TaxedPriceFactory;

class DoctrineOrderItemMapper extends GenericDoctrineMapper implements
    OrderItemMapperInterface
{
    /**
     * @var TaxedPriceFactory
     */
    private $priceFactory;

    public function __construct(
        ObjectManager $entityManager,
        FlushLock $flushLock,
        TaxedPriceFactory $priceFactory
    ) {
        parent::__construct(
            new \SclZfCart\Entity\OrderItem(),
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

    /**
     * @return OrderItem[]|null
     */
    public function findAllForOrder(Order $order)
    {
         return parent::fetchBy(['order' => $order]);
    }
}
