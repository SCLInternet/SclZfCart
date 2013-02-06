<?php

namespace SclZfCart\Storage;

use SclZfCart\Cart;

/**
 * Interface for storing & loading carts from the database.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface StorageInterface
{
    /**
     * Loads a cart from the database.
     *
     * @param int  $id
     * @param Cart $cart
     *
     * @return Cart
     */
    public function load($id, Cart $cart);

    /**
     * Stores a cart to the database
     *
     * @param Cart $cart
     *
     * @return int The cart identifier
     */
    public function store(Cart $cart);
}
