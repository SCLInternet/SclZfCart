<?php

namespace SclZfCart;

/**
 * Interface for class that provide an cart item UID string.
 * 
 * @author Tom Oram <tom@scl.co.uk>
 */
interface ProvidesUidInterface
{
    /**
     * Returns a cart item UID string
     * 
     * @return string
     */
    public function getUid();
}
