<?php
namespace SclZfCart\Listener;

use SclZfCart\CartEvent;

/**
 * Listener functions for the event manager
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @todo Consider implementing ListenerAggregateInterface, my concern is that it
 *     will have to be instantiated on every call even when not needed.
 */
class CartListener
{
    /**
     * This event finalises an order.
     *
     * The reason this is done as an event it that is is possible to other
     * modules will want to finalise at a different point.
     *
     * @param CartEvent $event
     */
    public static function completeOrder(CartEvent $event)
    {
        $cart = $event->getCart();
    }
}
