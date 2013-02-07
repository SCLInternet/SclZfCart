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

        if (!$uid) {
            // @todo Generate error or write log
            return $this->redirect()->toRoute('cart');
        }

        $cart = $this->getCart();

        $item = $cart->getItem($uid);

        $this->flashMessenger()->addInfoMessage(
            sprintf('%s has been removed from your cart.', $item->getTitle())
        );

        $this->getCart()->remove($item);

        return $this->redirect()->toRoute('cart');
    }
}
