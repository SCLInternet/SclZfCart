<?php

namespace SclZfCart\Controller;

use SclZfCart\Cart;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * The controller which takes the user through the checkout process.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CheckoutController extends AbstractActionController
{
    /**
     * Returns the shopping cart.
     *
     * @return Cart
     */
    private function getCart()
    {
        return $this->getServiceLocator()->get('SclZfCart\Cart');
    }

    /**
     * Displays the cart page.
     *
     * @return array
     */
    public function indexAction()
    {
        return array('cart' => $this->getCart());
    }

    /**
     * Removes an item from the cart
     *
     * @return array
     */
    public function removeItemAction()
    {
        $uid = $this->params('item');

        if ($uid) {
            $this->getCart()->remove($uid);
        }

        return $this->redirect()->toRoute('cart');
    }
}
