<?php

namespace SclZfCart\Mapper;

use SclZfCart\Entity\CartItemInterface;

/**
 * Interface for the mapper for loading a cart item from the database.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartItemMapperInterface
{
    /**
     * Creates a new instance of an cart item entity.
     *
     * @return CartItemInterface
     */
    public function create();

    /**
     * Persists to the cart item storage.
     *
     * @param  CartItemInterface $item
     * @return bool
    */
    public function save($item);

    /**
     * Loads a given cart item from the database.
     *
     * @param  int $id
     * @return CartItemInterface|null
    */
    public function findById($id);

    /**
     * Deletes the cart item from the storage.
     *
     * @param  CartItemInterface $cart
     * @return bool
    */
    public function delete($item);
}
