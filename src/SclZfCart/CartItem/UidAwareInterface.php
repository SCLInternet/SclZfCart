<?php

namespace SclZfCart\CartItem;

/**
 * Interface for classes which can have a UID set.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface UidAwareInterface extends UidProviderInterface
{
    /**
     * Returns the UID for the object.
     *
     * @param  string $uid
     * @return void
     */
    public function setUid($uid);
}
