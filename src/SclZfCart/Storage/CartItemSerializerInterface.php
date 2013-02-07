<?php

namespace SclZfCart\Storage;

use SclZfCart\CartItemInterface;

/**
 * Interface for serializing and unserializing cart item objects.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartItemSerializerInterface
{
    /**
     * Serializes a cart item to a string
     *
     * @param CartItemInterface $item
     * @return string
     */
    public function serialize(CartItemInterface $item);

    /**
     * Converts a serialized cart item back into an object
     *
     * @param string $data
     * @return CartItemInterface
     */
    public function unserialize($data);
}