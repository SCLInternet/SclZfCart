<?php

namespace SclZfCart\Mapper;

use SclZfCart\Entity\CartInterface;

/**
 * Interface for the mapper for loading a cart from the database.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CartMapperInterface
{
    /**
     * Creates a new instance of an cart object.
     *
     * @return CartInterface
     */
    public function create();

    /**
     * Persists to the cart storage.
     *
     * @param  CartInterface $cart
     * @return bool
    */
    public function save($cart);

    /**
     * Loads a given cart from the database.
     *
     * @param  int $id
     * @return CartInterface|null
    */
    public function findById($id);

    /**
     * Deletes the cart from the storage.
     *
     * @param  CartInterface $cart
     * @return bool
    */
    public function delete($cart);
}
