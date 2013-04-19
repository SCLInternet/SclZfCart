<?php

namespace SclZfCart;

use SclZfCart\Exception\InvalidArgumentException;
use SclZfUtilities\Model\Route;
use Zend\EventManager\Event;

/**
 * The cart event class.
 *
 * @author Tom Oram
 */
class CartEvent extends Event
{
    // Checkout events
    const EVENT_CHECKOUT       = 'checkout';
    const EVENT_PROCESS        = 'process-order';
    const EVENT_COMPLETE       = 'complete';

    // Order events
    const EVENT_ORDER_COMPLETE = 'order-complete';
    const EVENT_ORDER_FAIL     = 'order-failed';

    // Parameter names
    const PARAM_CART  = 'cart';

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

    /**
     * Returns the cart param.
     *
     * @return Cart|null
     */
    public function getCart()
    {
        $cart = $this->getParam(self::PARAM_CART);

        if (null === $cart) {
            return null;
        }

        if (!$cart instanceof Cart) {
            throw new InvalidArgumentException(
                '\SclZfCart\Cart',
                $cart,
                __METHOD__,
                __LINE__
            );
        }

        return $cart;
    }
}
