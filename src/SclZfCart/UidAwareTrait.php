<?php

namespace SclZfCart;

/**
 * Trait for objects that are UID aware.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
trait UidAwareTrait
{
    /**
     * The stored UID.
     *
     * @var string
     */
    protected $uid = '';

    /**
     * Returns a cart item UID string
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Returns the UID for the object.
     *
     * @param  string $uid
     * @return void
     */
    public function setUid($uid)
    {
        $this->uid = (string) $uid;
    }
}
