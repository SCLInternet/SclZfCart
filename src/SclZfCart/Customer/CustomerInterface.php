<?php

namespace SclZfCart\Customer;

use SclContact\ContactInterface;

/**
 * Interface for customer objects.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CustomerInterface
{
    /**
     * Get the unique ID of the customer.
     *
     * @return int
     */
    public function getId();

    /**
     * Set the ID of the customer.
     *
     * @param  int $id
     */
    public function setId($id);

    /**
     * Return the contact object.
     *
     * @return ContactInterface
     */
    public function getContact();

    /**
     * Set the contact object.
     *
     * @param  ContactInterface $contact
     */
    public function setContact(ContactInterface $contact);
}
