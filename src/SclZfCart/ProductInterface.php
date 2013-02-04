<?php

namespace SclZfCart;

/**
 * The interface for any item that wants to be added to the cart.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface ProductInterface
{
    /**
     * Return the main title of the product to be displayed it the cart.
     *
     * @return string
     */
    public function getTitle();

    /**
     * An extended description for the product.
     *
     * @return string
     */
    public function getDescription();
}
