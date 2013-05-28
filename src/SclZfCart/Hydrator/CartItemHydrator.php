<?php

namespace SclZfCart\Hydrator;

use SclZfCart\CartItemInterface;
use SclZfCart\Exception\InvalidArgumentException;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Hydrator for {@see CartItemInterface} objects
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @todo Add object type checking
 */
class CartItemHydrator implements HydratorInterface
{
    /**
     * Extract data from a CartItem object
     *
     * @param  CartItemInterface $item
     * @return array
     */
    public function extract($item)
    {
        if (!$item instanceof CartItemInterface) {
            return array();
        }

        return array(
            'uid'      => $item->getUid(),
            'type'     => get_class($item),
            'quantity' => $item->getQuantity(),
            'data'     => $item->serialize(),
        );
    }

    /**
     * Hydrates a cart item.
     *
     * @param  array             $data
     * @param  CartItemInterface $item
     * @return CartItemInterface
     * @throws InvalidArguementException
     */
    public function hydrate(array $data, $item)
    {
        if (!$item instanceof $data['type']) {
            // @todo should be DomainException
            throw new InvalidArgumentException(
                $data['type'],
                $item,
                __METHOD__,
                __LINE__
            );
        }

        $item->setUid($data['uid'])
             ->setQuantity($data['quantity']);

        $item->unserialize($data['data']);

        return $item;
    }
}
