<?php

namespace SclZfCart\CartItem;

/**
 * Interface for items which have a title and description.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface TitleProviderInterface
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
    public function getDesciption();
}
