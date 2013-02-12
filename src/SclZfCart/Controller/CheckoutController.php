<?php

namespace SclZfCart\Controller;

use Zend\EventManager\EventManagerInterface;

use SclZfCart\CartEvent;
use SclZfCart\Utility\Route;
use Zend\EventManager\EventInterface;
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
    private $eventManager;

    /**
     * Return the cart event manager.
     *
     * @return EventManagerInterface
     */
    private function getCartEventManager()
    {
        if (null === $this->eventManager) {
            $this->eventManager = $this->getCart()->getEventManager();
        }

        return $this->eventManager;
    }

    /**
     * @return \Zend\Http\Response|null
     */
    private function triggerCheckoutEvent()
    {
        /* @var $cart \SclZfCart\Cart */
        $cart = $this->getCart();

        $eventManager = $this->getCartEventManager();

        $results = $eventManager->trigger(CartEvent::EVENT_CHECKOUT, $cart);

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
    private function createCompleteForm()
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

        $this->getCartEventManager()->trigger(CartEvent::EVENT_COMPLETE_FORM, $form);

        return $form;
    }

    /**
     * Displays the checkout confirmation page
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

        return array(
            'form' => $this->createCompleteForm()
        );
    }

    /**
     * Displays the checkout completed page
     */
    public function completeAction()
    {
        return array();
    }
}
