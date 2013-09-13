<?php

namespace SclZfCartTests\Customer;

use SclZfCart\Customer\ZfcUserCustomerLocator;

/**
 * Unit tests for {@see ZfcUserCustomerLocator}.
 *
 * @covers SclZfCart\Customer\ZfcUserCustomerLocator
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class ZfcUserCustomerLocatorTest extends \PHPUnit_Framework_TestCase
{
    protected $locator;

    protected $authService;

    /**
     * Set up the instance to be tested.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->authService = $this->getMock('Zend\Authentication\AuthenticationService');

        $this->locator = new ZfcUserCustomerLocator($this->authService);
    }

    /*
     * getActiveCustomer()
     */

    public function test_getActiveCustomer_returns_logged_in_user()
    {
        $customer = $this->getMock('SclZfCart\Customer\CustomerInterface');

        $this->setLoggedInUser($customer);

        $this->assertInstanceOf(
            'SclZfCart\Customer\CustomerInterface',
            $this->locator->getActiveCustomer()
        );
    }

    public function test_getActiveCustomer_returns_null_if_not_logged_in()
    {
        $this->setLoggedInUser(false);

        $this->assertNull($this->locator->getActiveCustomer());
    }

    public function test_getActiveCustomer_throws_if_user_is_not_instance_of_CustomerInterface()
    {
        $user = $this->getMock('ZfcUser\Entity\UserInterface');

        $this->setLoggedInUser($user);

        $this->setExpectedException('SclZfCart\Exception\RuntimeException');

        $this->locator->getActiveCustomer();
    }

    /*
     * Private methods
     */

    private function setLoggedInUser($user)
    {
        $this->authService
             ->expects($this->any())
             ->method('getIdentity')
             ->will($this->returnValue($user));
    }
}
