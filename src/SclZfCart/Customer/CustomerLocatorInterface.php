<?php

namespace SclZfCart\Customer;

/**
 * Interface for a class which is used to locate a customer.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CustomerLocatorInterface
{
    /**
     * Returns the active customer.
     *
     * @return Customer|null Returns NULL if there is no active customer.
     */
    public function getActiveCustomer();
}
