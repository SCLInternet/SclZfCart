<?php

namespace SclZfCart\CartItem;

/**
 * Interface for cart items which provide a different quantity input element.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface QuantityElementProviderInterface
{
    /**
     * Returns true if more options need to be entered.
     *
     * @return \Zend\Form\ElementInterface|string
     */
    public function getQuantityElement();
}
