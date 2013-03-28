<?php

namespace SclZfCart\Form;

use SclZfCart\CartItem\QuantityElementProviderInterface;
use SclZfCart\CartItemInterface;
use SclZfCart\Exception\InvalidArgumentException;
use Zend\Form\ElementInterface;
use Zend\Form\Form;

/**
 * Displays the form for updating the cart quantities.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Cart extends Form
{
    /**
     * @var array:string
     */
    private $quantityMessages = array();

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
     * If the item provides a custom quantity element this method adds it to the form.
     *
     * @param CartInterfaceItem $item
     * @return boolean True is a custom element was provided
     */
    private function addCustomQuantityElement(CartItemInterface $item)
    {
        if (!$item instanceof QuantityElementProviderInterface) {
            return false;
        }

        $element = $item->getQuantityElement();

        if ($element instanceof \Zend\Form\ElementInterface) {
            $element->setName($item->getUid());
            $this->add($element);
            return true;
        }

        if (!is_scalar($element)) {
            throw new InvalidArgumentException(
                '\Zend\Form\ElementInterface or string',
                $element,
                __METHOD__,
                __LINE__
            );
        }

        $this->quantityMessages[$item->getUid()] = (string) $element;

        return true;
    }

    /**
     * Adds a quantity input for the given item.
     *
     * @param CartItemInterface $item
     * @return void
     */
    public function addItem(CartItemInterface $item)
    {
        if ($this->addCustomQuantityElement($item)) {
            return;
        }

        $this->add(
            array(
                'name' => $item->getUid(),
                'type' => 'Zend\Form\Element\Text',
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
     * @return \Zend\Form\Element|string|null
     */
    public function getQuantityElement(CartItemInterface $item)
    {
        $uid = $item->getUid();

        $element = $this->get($uid);

        if ($element) {
            return $element;
        }

        if (isset($this->quantityMessages[$uid])) {
            return (string) $this->quantityMessages[$uid];
        }

        return null;
    }

    /**
     * Returns the quantity from the for for the given item.
     *
     * @param CartItemInterface $item
     * @return scalar
     */
    public function getItemQuantity(CartItemInterface $item)
    {
        $element = $this->getQuantityElement($item);

        if ($element instanceof ElementInterface) {
            return (int) $this->getQuantityElement($item)->getValue();
        }

        return $element;
    }
}
