<?php

namespace SclZfCart\Exception;

/**
 * RuntimeException
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class RuntimeException extends \RuntimeException
{
    public static function invalidCustomer($customer)
    {
        return new self(
            sprintf(
                'Instance of SclZfCart\Customer\CustomerInterface expected; got "%s".',
                is_object($customer) ? get_class($customer) : gettype($customer)
            )
        );
    }

    public static function expectedOrder($order)
    {
        return new self(
            sprintf(
                'Instance of SclZfCart\Entity\OrderInterface expected; got "%s".',
                is_object($order) ? get_class($order) : gettype($order)
            )
        );

    }
}
