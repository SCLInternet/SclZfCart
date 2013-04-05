<?php

namespace SclZfCart\Service;

use SclZfCart\CartItemInterface;
use SclZfCart\Service\Exception;

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
     * @throws Exception\DomainException
     */
    public function create($type);
}
