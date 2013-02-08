<?php

namespace SclZfCart\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Shows the user the cart and allows the management of it.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartController extends AbstractActionController
{
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
