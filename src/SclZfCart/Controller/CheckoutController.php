<?php

namespace SclZfCart\Controller;

use SclZfCart\CartEvent;
use SclZfCart\CartItem\CheckoutOptionsInterface;
use SclZfCart\Utility\Route;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Takes the user through the checkout process.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CheckoutController extends AbstractActionController
{
    /**
     * Displays the cart page.
     *
     * @return array
     */
    public function indexAction()
    {
        //if (/* User not logged in */) {
        //    // Redirect to user signup
        //}

        /* @var $cart \SclZfCart\Cart */
        $cart = $this->getCart();

        $eventManager = $cart->getEventManager();

        $results = $eventManager->trigger(CartEvent::EVENT_CHECKOUT, $cart);

        foreach ($results as $result) {
            if ($result instanceof Route) {
                return $this->redirect()->toRoute($result->route, $result->params);
            }
        }

        // Shipping in the future.

        // Display confirmation page
    }

    /**
     * Displays the checkout completed page
     */
    public function completeAction()
    {
        
    }
}
