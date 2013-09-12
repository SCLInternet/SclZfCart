<?php

namespace SclZfCart\CartItem;

/**
 * Interface for cart items which contain extra information which needs to be stored.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface DataAwareInterface
{
    /**
     * Fill out the cart item with the additional values in $data.
     *
     * @param  string $data The serialized data values.
     * @return void
     */
    public function setData($data);

    /**
     * Return a serialize string of additional data values.
     *
     * @return string
     */
    public function getData();
}
