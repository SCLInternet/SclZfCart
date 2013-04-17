<?php

namespace SclZfCart\Controller;

use SclZfCart\CartEvent;
use SclZfUtilities\Model\Route;
use Zend\Form\Form;
use Zend\EventManager\EventManagerInterface;
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
            array(CartEvent::PARAM_CART => $cart)
        );

        foreach ($results as $result) {
            if ($result instanceof Route) {
                return $this->redirect()->toRoute($result->route, $result->params);
            }
        }

        return null;
    }

    /**
     * Builds the form object which shows the complete button.
     *
     * @return Form
     */
    protected function createCompleteForm()
    {
        $form = new Form();

        $form->setAttribute('action', $this->url()->fromRoute('cart/checkout/complete'));

        $form->add(
            array(
                'name' => 'complete',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => array(
                    'value' => 'Confirm',
                    'id'    => 'complete-order',
                ),
            )
        );

        $this->getCartEventManager()->trigger(
            CartEvent::EVENT_COMPLETE_FORM,
            $form,
            array(CartEvent::PARAM_CART => $this->getCart())
        );

        return $form;
    }

    /**
     * Starts the checkout processs and displays the checkout confirmation page.
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

        // @todo Save the order here.

        return array(
            'form' => $this->createCompleteForm()
        );
    }

    /**
     * Finalise the cart contents to and order and move on the the appropriate page.
     *
     * @return array
     */
    public function processAction()
    {
        $cart     = $this->getCart();
        $transfer = $this->getServiceLocator()->get('SclZfCart\Service\CartTransferService');
        $mapper   = $this->getServiceLocator()->get('SclZfCart\Mapper\OrderMapperInterface');
        $order = $mapper->create();

        $transfer->cartToOrder($cart, $order);

        $cart->clear();

        $mapper->save($order);

        // @todo Trigger the process event.

        //return $this->redirect()->toRoute('order/redirect', array('id' => $order->getId()));
        return array();
    }

    /**
     * Displays the result of the checkout process
     */
    public function completedAction()
    {
        $cart = $this->getCart();

        $this->getCartEventManager()->trigger(
            CartEvent::EVENT_COMPLETE,
            $cart,
            array(CartEvent::PARAM_CART => $cart)
        );

        return array();
    }
}
