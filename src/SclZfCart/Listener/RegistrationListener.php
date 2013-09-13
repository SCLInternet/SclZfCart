<?php

namespace SclZfCart\Listener;

use SclZfCart\CartEvent;
use SclZfCart\Customer\CustomerLocatorInterface;
use SclZfUtilities\Model\Route;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;

class RegistrationListener implements SharedListenerAggregateInterface
{
    const EVENT_MANAGER_ID = 'SclZfCart\Cart';

    private $listeners;

    private $customerLocator;

    public function __construct(CustomerLocatorInterface $customerLocator)
    {
        $this->customerLocator = $customerLocator;
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
            CartEvent::EVENT_CHECKOUT,
            array($this, 'checkout')
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

    /**
     * Intercept the checkout process if no user is logged in.
     *
     * @param  CartEvent $event
     * @return null|Route
     * @todo   Set the value of the Route object.
     */
    public function checkout(CartEvent $event)
    {
        if (!$this->customerLocator->getActiveCustomer()) {
            return new Route('x');
        }

        return null;
    }
}
