<?php

namespace SclZfCart\Storage;

use SclZfCart\CartItemInterface;
use SclZfCart\Exception\InvalidArgumentException;

/**
 * Class for serializing and unserializing cart item objects.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartItemSerializer implements CartItemSerializerInterface
{
    /**
     * {@inheritDoc}
     *
     * @param CartItemInterface $item
     * @return string
     */
    public function serialize(CartItemInterface $item)
    {
        return serialize($item);
    }

    /**
     * {@inheritDoc}
     *
     * @param string $data
     * @return CartItemInterface
     * @throws InvalidArgumentException
     */
    public function unserialize($data)
    {
        $item = @unserialize($data);

        if (!$item instanceof CartItemInterface) {
            throw new InvalidArgumentException(
                '\SclZfCart\CartItemInterface',
                $item,
                __CLASS__ . '::' . __METHOD__,
                __LINE__
            );
        }

        return $item;
    }
}
