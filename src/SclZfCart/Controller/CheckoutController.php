<?php

namespace SclZfCart\Controller;

use SclZfCart\CartItem\CheckoutOptionsInterface;

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
     * @todo Consider the pros & cons of using the EventManager instead
     */
    public function indexAction()
    {
        //if (/* User not logged in */) {
        //    // Redirect to user signup
        //}

        $cart = $this->getCart();

        foreach ($cart->getItems() as $item) {
            if (!$item instanceof CheckoutOptionsInterface) {
                continue;
            }

            /* @var $item \SclZfCart\CartItem\CheckoutOptionsInterface */

            // Redirect to product options page
            if (!$item->checkoutOptionsCompleted()) {
                $route = $item->checkoutOptionsRedirect();
                return $this->redirect()->toRoute($route->route, $route->params);
            }
        }

        // Shipping in the future.

        // Take payment
    }
}
