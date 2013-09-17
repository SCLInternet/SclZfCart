<?php

namespace SclZfCart\Customer;

use SclZfCart\Customer\CustomerInterface;
use SclZfCart\Exception\RuntimeException;
use Zend\Authentication\AuthenticationService;

/**
 * Implementation of {@see CustomerLocatorInterface} which fetches the currently
 * logged in ZfcUser as the active customer.
 *
 * To use this locator you ZfcUser User entity must implement {@see CustomerInterface}.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class ZfcUserCustomerLocator implements CustomerLocatorInterface
{
    /**
     * The ZfcUser authentication service.
     *
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * Save the auth service
     *
     * @param  AuthenticationService $authService
     */
    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * {@inheritDoc}
     */
    public function getActiveCustomer()
    {
        $customer = $this->authService->getIdentity();

        if (!$customer) {
            return null;
        }

        if (!$customer instanceof CustomerInterface) {
            throw RuntimeException::invalidCustomer($customer);
        }

        return $customer;
    }
}
