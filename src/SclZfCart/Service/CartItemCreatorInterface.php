<?php

namespace SclZfCart\Service;

use SclZfCart\CartItemInterface;

/**
 * Creates cart items of given types.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartItemCreatorInterface
{
    /**
     * Creates a Cart Item of the specified type.
     *
     * @param  string $type
     * @return CartItemInterface
     */
    public function create($type);
}
