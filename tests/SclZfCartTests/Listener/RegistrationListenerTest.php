<?php

namespace SclZfCartTests\Listener;

use SclZfCart\CartEvent;
use SclZfCart\Listener\RegistrationListener;

/**
 * Unit tests for {@see RegistrationListener}.
 *
 * @covers SclZfCart\Listener\RegistrationListener
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class RegistrationListenerTest extends \PHPUnit_Framework_TestCase
{
    private $listener;

    private $locator;

    private $event;

    /**
     * Set up the instance to be tested.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->events = $this->getMock('\Zend\EventManager\SharedEventManagerInterface');

        $this->locator = $this->getMock('\SclZfCart\Customer\CustomerLocatorInterface');

        $this->listener = new RegistrationListener($this->locator);

        $this->event = $this->getMock('SclZfCart\CartEvent');
    }

    /*
     * attach()
     */

    public function test_attach_attaches_checkout_event()
    {
        $this->events
             ->expects($this->once())
             ->method('attach')
             ->with(
                  $this->equalTo('SclZfCart\Cart'),
                  $this->equalTo(CartEvent::EVENT_CHECKOUT),
                  $this->equalTo(array($this->listener, 'checkout'))
             );

        $this->listener->attachShared($this->events);
    }

    /*
     * detach()
     */

    public function test_detach_detaches_checkout_listener()
    {
        $handler = $this->attachListener('checkout');

        $this->events
             ->expects($this->once())
             ->method('detach')
             ->with(
                $this->identicalTo('SclZfCart\Cart'),
                $this->identicalTo($handler)
            );

        $this->listener->detachShared($this->events);
    }

    /*
     * checkout()
     */

    public function test_checkout_returns_null_when_active_customer_exists()
    {
        $customer = $this->getMock('\SclZfCart\Customer\CustomerInterface');

        $this->setActiveCustomer($customer);

        $this->assertNull($this->listener->checkout($this->event));
    }

    public function test_checkout_returns_Route_if_active_customer_not_found()
    {
        $this->setActiveCustomer(null);

        $this->assertInstanceOf(
            '\SclZfUtilities\Model\Route',
            $this->listener->checkout($this->event)
        );
    }

    /*
     * Private methods
     */

    private function attachListener($listenerName)
    {
        $handler = $this->getMockBuilder('Zend\Stdlib\CallbackHandler')
                        ->disableOriginalConstructor()
                        ->getMock();

        $this->events
             ->expects($this->once())
             ->method('attach')
             ->with(
                $this->equalTo('SclZfCart\Cart'),
                $this->equalTo(CartEvent::EVENT_CHECKOUT),
                $this->equalTo(array($this->listener, 'checkout'))
             )
             ->will($this->returnValue($handler));

        $this->listener->attachShared($this->events);

        return $handler;
    }

    private function setActiveCustomer($customer)
    {
        $this->locator
             ->expects($this->any())
             ->method('getActiveCustomer')
             ->will($this->returnValue($customer));
    }
}
