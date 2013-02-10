<?php

namespace SclZfCart;

use SclZfCart\Utility\Route;
use Zend\EventManager\Event;

/**
 * The cart event class.
 *
 * @author Tom Oram
 */
class CartEvent extends Event
{
    const EVENT_CHECKOUT = 'checkout';

    /**
     * @var Route
     */
    private $route;

    /**
     * Set the route
     *
     * @param Route $route
     * @return void
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;
    }

    /**
     * Get the route
     *
     * @return Route|null
     */
    public function getRoute()
    {
        return $this->route;
    }
}
