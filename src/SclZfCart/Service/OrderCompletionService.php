<?php

namespace SclZfCart\Service;

use SclZfCart\Mapper\OrderMapperInterface;
use SclZfCart\Entity\OrderInterface;

/**
 * Marks a payment as completed.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class OrderCompletionService
{
    /**
     * The mapper for saving a payment.
     *
     * @var OrderMapperInterface
     */
    protected $mapper;

    /**
     *
     * @param OrderMapperInterface $mapper
     */
    public function __construct(OrderMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * Mark an order as successfully completing.
     *
     * @param OrderInterface $order
     */
    public function complete(OrderInterface $order)
    {
        $order->setStatus(OrderInterface::STATUS_COMPLETED);

        $this->mapper->save($order);
    }

    /**
     * Mark an order as failed.
     *
     * @param OrderInterface $payment
     */
    public function fail(OrderInterface $order)
    {
        $order->setStatus(OrderInterface::STATUS_FAILED);

        $this->mapper->save($order);
    }
}
