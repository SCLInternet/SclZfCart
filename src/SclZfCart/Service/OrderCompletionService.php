<?php

namespace SclZfCart\Service;

use SclZfCart\Mapper\OrderMapperInterface;
use SclZfCart\Entity\OrderInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use SclZfCart\CartEvent;

/**
 * Marks a payment as completed.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class OrderCompletionService implements EventManagerAwareInterface
{
    /**
     * The mapper for saving a payment.
     *
     * @var OrderMapperInterface
     */
    protected $mapper;

    /**
     * The event manager.
     *
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     *
     * @param OrderMapperInterface $mapper
     */
    public function __construct(OrderMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * {@inheritDoc}
     *
     * @param  EventManagerInterface $eventManager
     * @return self
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(
            array(
                __CLASS__,
                get_called_class(),
            )
        );

        $eventManager->setEventClass('SclZfCart\CartEvent');

        $this->eventManager = $eventManager;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @see EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * Mark an order as successfully completing.
     *
     * @param OrderInterface $order
     */
    public function complete(OrderInterface $order)
    {
        $order->setStatus(OrderInterface::STATUS_COMPLETED);

        $this->getEventManager()->trigger(CartEvent::EVENT_ORDER_COMPLETE, $order);

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

        $this->getEventManager()->trigger(CartEvent::EVENT_ORDER_FAIL, $order);

        $this->mapper->save($order);
    }
}
