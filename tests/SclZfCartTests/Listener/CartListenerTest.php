<?php

namespace SclZfCartTests\Listener;

use SclZfCart\CartEvent;
use SclZfCart\Listener\CartListener;

/**
 * Unit tests for {@see RegistrationListener}.
 *
 * @covers SclZfCart\Listener\CartListener
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartListenerTest extends \PHPUnit_Framework_TestCase
{
    const LOGIN_ROUTE = 'login/page';
    const ORDER_ID    = 123;

    private $listener;

    private $eventManager;

    private $locator;

    private $orderService;

    private $event;

    private $order;

    /**
     * Set up the instance to be tested.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->events = $this->getMock('Zend\EventManager\SharedEventManagerInterface');

        $this->locator = $this->getMock('SclZfCart\Customer\CustomerLocatorInterface');

        $this->eventManager = $this->getMock('Zend\EventManager\EventManagerInterface');

        $this->orderService = $this->getMockBuilder('SclZfCart\Service\OrderCompletionService')
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->listener = new CartListener(
            $this->eventManager,
            $this->locator,
            $this->orderService,
            self::LOGIN_ROUTE
        );

        $this->createEvent(self::ORDER_ID);
    }


    /*
     * attach()
     */

    public function test_attach_attaches_events()
    {
        $this->events
             ->expects($this->at(0))
             ->method('attach')
             ->with(
                  $this->equalTo('SclZfCart\Cart'),
                  $this->equalTo(CartEvent::EVENT_PROCESS),
                  $this->equalTo([$this->listener, 'process']),
                  $this->equalTo(0)
             );

        $this->events
             ->expects($this->at(1))
             ->method('attach')
             ->with(
                  $this->equalTo('SclZfCart\Cart'),
                  $this->equalTo(CartEvent::EVENT_CHECKOUT),
                  $this->equalTo([$this->listener, 'checkout']),
                  $this->equalTo(0)
             );

        $this->events
             ->expects($this->at(2))
             ->method('attach')
             ->with(
                  $this->equalTo('SclZfCart\Cart'),
                  $this->equalTo(CartEvent::EVENT_COMPLETE),
                  $this->equalTo([$this->listener, 'complete']),
                  $this->equalTo(0)
             );

        $this->listener->attachShared($this->events);
    }

    /*
     * process()
     */

    public function test_process_returns_Route()
    {
        $this->assertInstanceOf(
            'SclZfUtilities\Model\Route',
            $this->listener->process($this->event)
        );
    }

    public function test_process_returns_checkout_action_in_route()
    {
        $route = $this->listener->process($this->event);

        $this->assertEquals('cart/checkout/complete', $route->route);
    }

    public function test_process_sets_id_in_returned_route()
    {
        $route = $this->listener->process($this->event);

        $this->assertArrayHasKey('id', $route->params);
    }

    public function test_process_param_id_is_order_id()
    {
        $route = $this->listener->process($this->event);

        $this->assertEquals(self::ORDER_ID, $route->params['id']);
    }

    public function test_process_triggers_complete_event()
    {
        $this->eventManager
             ->expects($this->once())
             ->method('trigger')
             ->with($this->equalTo(CartEvent::EVENT_COMPLETE));

        $this->listener->process($this->event);
    }

    public function test_process_sets_order_as_complete_event_target()
    {
        $this->eventManager
             ->expects($this->once())
             ->method('trigger')
             ->with($this->anything(), $this->identicalTo($this->order));

        $this->listener->process($this->event);
    }

    public function test_process_throws_if_event_target_is_not_an_order()
    {
        $this->event->setTarget(new \stdClass());

        $this->setExpectedException('SclZfCart\Exception\RuntimeException');

        $this->listener->process($this->event);
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

    public function test_checkout_Route_constains_correct_value()
    {
        $this->setActiveCustomer(null);

        $route = $this->listener->checkout($this->event);

        $this->assertEquals(self::LOGIN_ROUTE, $route->route);
    }

    /*
     * complete()
     */

    public function test_complete_completes_the_order()
    {
        $this->orderService
             ->expects($this->once())
             ->method('complete')
             ->with($this->identicalTo($this->order));

        $this->listener->complete($this->event);
    }

    public function test_complete_throws_if_event_doesnt_contain_order()
    {
        $this->setExpectedException('SclZfCart\Exception\RuntimeException');

        $this->listener->complete(new CartEvent());
    }

    /*
     * Private methods
     */

    private function createEvent($orderId)
    {
        $this->order = $this->getMock('SclZfCart\Entity\OrderInterface');

        $this->order->expects($this->any())
              ->method('getId')
              ->will($this->returnValue($orderId));

        $this->event = new CartEvent();

        $this->event->setTarget($this->order);
    }

    private function setActiveCustomer($customer)
    {
        $this->locator
             ->expects($this->any())
             ->method('getActiveCustomer')
             ->will($this->returnValue($customer));
    }
}
