<?php

namespace SclZfCart\Service;

use SclZfCart\Mapper\OrderMapperInterface;
use SclZfCart\Entity\Order;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use SclZfCart\CartEvent;

class OrderCompletionService implements EventManagerAwareInterface
{
    /**
     * @var OrderMapperInterface
     */
    private $mapper;

    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    public function __construct(OrderMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

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
    }

    /**
     * @see EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function complete(Order $order)
    {
        $order->setStatus(Order::STATUS_COMPLETED);

        $this->getEventManager()->trigger(CartEvent::EVENT_ORDER_COMPLETE, $order);

        $this->mapper->save($order);
    }

    public function fail(Order $order)
    {
        $order->setStatus(Order::STATUS_FAILED);

        $this->getEventManager()->trigger(CartEvent::EVENT_ORDER_FAIL, $order);

        $this->mapper->save($order);
    }
}
