<?php

namespace SclZfCart\Controller;

use SclZfCart\CartEvent;
use SclZfCart\Entity\OrderInterface;
use SclZfUtilities\Model\Route;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Takes the user through the checkout process.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CheckoutController extends AbstractActionController
{
    /**
     * The cart event manager.
     *
     * @var EventManagerInterface
     */
    protected $cartEventManager;

    /**
     * Return the cart event manager.
     *
     * @return EventManagerInterface
     */
    protected function getCartEventManager()
    {
        if (null === $this->cartEventManager) {
            $this->cartEventManager = $this->getCart()->getEventManager();
        }

        return $this->cartEventManager;
    }

    //
    // indexAction
    //

    /**
     * @return \Zend\Http\Response|null
     */
    protected function triggerCheckoutEvent()
    {
        /* @var $cart \SclZfCart\Cart */
        $cart = $this->getCart();

        $eventManager = $this->getCartEventManager();

        $results = $eventManager->trigger(
            CartEvent::EVENT_CHECKOUT,
            $cart,
            [CartEvent::PARAM_CART => $cart]
        );

        foreach ($results as $result) {
            if ($result instanceof Route) {
                return $this->redirect()->toRoute($result->route, $result->params);
            }
        }

        return null;
    }

    /**
     * Creates a form which provides the button to take customer to the confirm page.
     *
     * @return Form
     * @todo Include a hash of the cart.
     */
    public function createConfirmForm()
    {
        $form = new Form('cart-confirm-form');

        $form->setAttribute('action', $this->url()->fromRoute('cart/checkout/process'));

        $form->add(
            array(
                'name' => 'complete',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => [
                    'value' => 'Confirm',
                    'id'    => 'complete-order',
                    'class' => 'btn',
                ],
            )
        );

        return $form;
    }

    /**
     * Starts the checkout processs and displays the checkout confirmation page.
     *
     * Starts the checkout process and displays an pages required before the confirmation page.
     * This action triggers the CartEvent::EVENT_CHECKOUT event.
     *
     * @return array
     */
    public function indexAction()
    {
        //if (/* User not logged in */) {
        //    // Redirect to user signup
        //}

        $redirect = $this->triggerCheckoutEvent();
        if (null !== $redirect) {
            return $redirect;
        }

        return [
            'form' => $this->createConfirmForm(),
        ];
    }

    //
    // processAction
    //

    /**
     * @param  OrderInterface $order
     * @return \Zend\Http\Response|null
     */
    protected function triggerProcessEvent(OrderInterface $order)
    {
        $eventManager = $this->getCartEventManager();

        $results = $eventManager->trigger(CartEvent::EVENT_PROCESS, $order);

        foreach ($results as $result) {
            if ($result instanceof Route) {
                return $this->redirect()->toRoute($result->route, $result->params);
            }

            if ($result instanceof Form) {
                return $result;
            }
        }

        return null;
    }

    /**
     * Builds the form object which shows the complete button.
     *
     * @return Form
     */
    /*
     protected function createCompleteForm()
     {
        $form = new Form();

        $form->setAttribute('action', $this->url()->fromRoute('cart/checkout/complete'));

        $form->add(
            array(
                'name' => 'complete',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => [
                    'value' => 'Confirm',
                    'id'    => 'complete-order',
                ],
            )
        );

        $this->getCartEventManager()->trigger(
            CartEvent::EVENT_COMPLETE_FORM,
            $form,
            [CartEvent::PARAM_CART => $this->getCart()]
        );

        return $form;
    }
    */

    /**
     * Finalise the cart contents to and order and move on the the appropriate page.
     *
     * @return array|Response
     */
    public function processAction()
    {
        $cart     = $this->getCart();
        $transfer = $this->getServiceLocator()->get('SclZfCart\Service\CartToOrderService');
        $mapper   = $this->getServiceLocator()->get('SclZfCart\Mapper\OrderMapperInterface');
        $order = $mapper->create();

        $transfer->cartToOrder($cart, $order);

        $cart->clear();

        $mapper->save($order);

        $result = $this->triggerProcessEvent($order);

        if ($result instanceof \Zend\Http\Response) {
            return $result;
        }

        if ($result instanceof Form) {
            return [
                'form' => $result,
            ];
        }

        // @todo Throw an exception here
        return [];
    }

    //
    // completedAction
    //

    /**
     * Displays the result of the checkout process
     */
    public function completedAction()
    {
        // @todo Check the user is allowed to see this order progress.

        // @todo Load the order

        return [];
    }
}
