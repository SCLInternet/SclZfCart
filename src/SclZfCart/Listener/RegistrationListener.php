<?php

namespace SclZfCart\Listener;

use SclZfCart\CartEvent;
use SclZfCart\Customer\CustomerLocatorInterface;
use SclZfCart\Entity\OrderInterface;
use SclZfCart\Exception\RuntimeException;
use SclZfUtilities\Model\Route;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
use SclZfCart\Service\OrderCompletionService;

/**
 * Intercepts the checkout process if the user is not registered.
 *
 * @author Tom Oram <tom@scl.co.uk>
 *
 * @todo   Pass in service locator rather than individual objects as then
 *         may not be required and this will get created on every load via
 *         the module bootstrap.
 */
class RegistrationListener implements SharedListenerAggregateInterface
{
    const EVENT_MANAGER_ID = 'SclZfCart\Cart';

    const PROCESS_PREFERENCE  = 0;
    const CHECKOUT_PREFERENCE = 0;
    const COMPLETE_PREFERENCE = 0;

    private $listeners;

    private $eventManager;

    private $customerLocator;

    private $orderService;

    private $loginRoute;

    /**
     * __construct
     *
     * @param  CustomerLocatorInterface $customerLocator
     * @param  string                   $loginRoute
     */
    public function __construct(
        EventManagerInterface $eventManager,
        CustomerLocatorInterface $customerLocator,
        OrderCompletionService $orderService,
        $loginRoute
    ) {
        $this->eventManager    = $eventManager;
        $this->customerLocator = $customerLocator;
        $this->loginRoute      = $loginRoute;
        $this->orderService    = $orderService;
    }

    /**
     * Attach one or more listeners
     *
     * @param SharedEventManagerInterface $events
     * @todo  Add priority values
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            self::EVENT_MANAGER_ID,
            CartEvent::EVENT_PROCESS,
            array($this, 'process'),
            self::PROCESS_PREFERENCE
        );

        $this->listeners[] = $events->attach(
            self::EVENT_MANAGER_ID,
            CartEvent::EVENT_CHECKOUT,
            array($this, 'checkout'),
            self::CHECKOUT_PREFERENCE
        );

        $this->listeners[] = $events->attach(
            self::EVENT_MANAGER_ID,
            CartEvent::EVENT_COMPLETE,
            array($this, 'complete'),
            self::COMPLETE_PREFERENCE
        );
    }

    /**
     * Detach all previously attached listeners
     *
     * @param SharedEventManagerInterface $events
     */
    public function detachShared(SharedEventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach(self::EVENT_MANAGER_ID, $listener);
        }
    }

    public function process(CartEvent $event)
    {
        $order = $event->getTarget();

        if (!$order instanceof OrderInterface) {
            throw RuntimeException::expectedOrder($order);
        }

        $this->eventManager->trigger(CartEvent::EVENT_COMPLETE, $order);

        // @todo Move action into config
        return new Route('cart/checkout/complete', ['id' => $order->getId()]);
    }

    /**
     * Intercept the checkout process if no user is logged in.
     *
     * @param  CartEvent $event
     * @return null|Route
     */
    public function checkout(CartEvent $event)
    {
        if (!$this->customerLocator->getActiveCustomer()) {
            return new Route($this->loginRoute);
        }

        return null;
    }

    public function complete(CartEvent $event)
    {
        $order = $event->getTarget();

        $this->orderService->complete($order);
    }
}
