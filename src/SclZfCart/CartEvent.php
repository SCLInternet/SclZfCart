<?php

namespace SclZfCart;

use SclZfCart\Exception\InvalidArgumentException;
use SclZfCart\Utility\Route;
use Zend\EventManager\Event;

/**
 * The cart event class.
 *
 * @author Tom Oram
 */
class CartEvent extends Event
{
    const EVENT_CHECKOUT      = 'checkout';
    const EVENT_COMPLETE_FORM = 'complete_form';
    const EVENT_COMPLETE      = 'complete';

    const PARAM_CART = 'cart';

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
