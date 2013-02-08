<?php

namespace SclZfCart\CartItem;

/**
 * Interface for a product which requires some options to be entered at checkout.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface CheckoutOptionsInterface
{
    /**
     * Returns true if more options need to be entered.
     *
     * @return boolean
     */
    public function checkoutOptionsCompleted();

    /**
     * Returns the redirect object to the location where the options can be entered.
     *
     * @return \SclZfCart\Utility\Route
     */
    public function checkoutOptionsRedirect();
}