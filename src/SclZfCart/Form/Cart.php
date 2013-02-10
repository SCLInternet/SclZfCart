<?php

namespace SclZfCart\Form;

use SclZfCart\CartItem\QuantityElementProviderInterface;

use SclZfCart\CartItemInterface;

use Zend\Form\Form;

/**
 * Displays the form for updating the cart quantities.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Cart extends Form
{
    /**
     * Setup the submit buttons
     */
    public function __construct()
    {
        parent::__construct('cart-form');

        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'name' => 'update',
                'attributes' => array(
                    'type' => 'submit',
                    'value' => 'Update Cart',
                    'id' => 'update-cart',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'checkout',
                'attributes' => array(
                    'type' => 'submit',
                    'value' => 'Checkout',
                    'id' => 'checkout-cart',
                ),
            )
        );
    }

    /**
     * Adds a quantity input for the given item.
     *
     * @param CartItemInterface $item
     * @return void
     */
    public function addItem(CartItemInterface $item)
    {
        if ($item instanceof QuantityElementProviderInterface) {
            $element = $item->getQuantityElement();
            $element->setName($item->getUid());
            $this->add($element);
            return;
        }

        $this->add(
            array(
                'name' => $item->getUid(),
                'type' => 'text',
                'attributes' => array(
                    'value' => $item->getQuantity(),
                )
            )
        );
    }

    /**
     * Returns the quantity element for the given item.
     *
     * @param CartItemInterface $item
     * @return \Zend\Form\Element
     */
    public function getQuantityElement(CartItemInterface $item)
    {
        return $this->get($item->getUid());
    }

    /**
     * Returns the quantity from the for for the given item.
     *
     * @param CartItemInterface $item
     * @return int|null
     */
    public function getItemQuantity(CartItemInterface $item)
    {
        $element = $this->getQuantityElement($item);

        if (!$element) {
            return null;
        }

        return (int) $this->getQuantityElement($item)->getValue();
    }
}
