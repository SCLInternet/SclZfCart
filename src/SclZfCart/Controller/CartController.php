<?php

namespace SclZfCart\Controller;

use SclZfCart\Form\Cart as CartForm;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Shows the user the cart and allows the management of it.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartController extends AbstractActionController
{
    /**
     * Updates the quantities of the items in the cart from the from values.
     *
     * @param CartForm $form
     * @return void
     */
    private function updateCartQuantities(CartForm $form)
    {
        /* @var $item \SclZfCart\CartItemInterface */
        foreach ($this->getCart()->getItems() as $item) {
            $quantity = $form->getItemQuantity($item);

            if (null === $quantity) {
                continue;
            }

            $item->setQuantity($quantity);
        }
    }

    /**
     * Updates the cart and checks if the checkout button was pressed
     *
     * @param CartForm $form
     * @return mixed
     */
    private function updateAndCheckout(CartForm $form)
    {
        if (!$this->formSubmitted($form)) {
            return false;
        }

        $this->updateCartQuantities($form);

        if (!$this->getRequest()->getPost('checkout')) {
            // Performing redirect to mark sure the quantity values are correct
            $this->flashMessenger()->addSuccessMessage('The cart contents has been updated');
            return $this->redirect()->toRoute('cart');
        }

        return $this->redirect()->toRoute('cart/checkout');
    }

    /**
     * Displays the cart page.
     *
     * @return array
     */
    public function indexAction()
    {
        /* @var $cart \SclZfCart\Cart */
        $cart = $this->getCart();

        /* @var $form CartForm */
        $form = $this->getServiceLocator()->get('SclZfCart\Form\Cart');

        foreach ($cart->getItems() as $item) {
            $form->addItem($item);
        }

        $redirect = $this->updateAndCheckout($form);

        if ($redirect) {
            return $redirect;
        }

        return array(
            'form' => $form,
            'cart' => $cart,
        );
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
