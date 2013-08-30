<?php

namespace SclZfCart\Hydrator;

use SclZfCart\Entity\OrderItemInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Hydrator for {@see OrderItemInterface} objects
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @todo Add object type checking
 */
class OrderItemEntityHydrator implements HydratorInterface
{
    /**
     * Extract data from a OrderItem object
     *
     * @param  OrderItemInterface $item
     * @return array
     */
    public function extract($item)
    {
        if (!$item instanceof OrderItemInterface) {
            return array();
        }

        return array(
            'uid'      => $item->getUid(),
            'type'     => $item->getType(),
            'quantity' => $item->getQuantity(),
            'data'     => $item->getData(),
            'price'    => $item->getPrice(),
        );
    }

    /**
     * Hydrates a cart item.
     *
     * @param  array              $data
     * @param  OrderItemInterface $item
     * @return OrderItemInterface
     */
    public function hydrate(array $data, $item)
    {
        if (!$item instanceof OrderItemInterface) {
            return $item;
        }

        $item->setUid($data['uid']);
        $item->setType($data['type']);
        $item->setQuantity($data['quantity']);
        $item->setData($data['data']);
        $item->setPrice($data['price']);

        return $item;
    }
}
