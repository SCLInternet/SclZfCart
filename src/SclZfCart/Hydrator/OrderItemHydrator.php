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
class OrderItemHydrator implements HydratorInterface
{
    /**
     * Check that
     * @param  OrderItemInterface $item
     */
    protected function checkType(OrderItemInterface $item)
    {
        // Type checking is done via typehinting
    }

    /**
     * Extract data from a OrderItem object
     *
     * @param  OrderItemInterface $item
     * @return array
     */
    public function extract($item)
    {
        $this->checkType($item);

        return array(
            'uid'      => $item->getUid(),
            'type'     => $item->getType(),
            'quantity' => $item->getQuantity(),
            'data'     => $item->serialize(),
            'price'    => $item->getPrice(),
        );
    }

    /**
     * Hydrates a cart item.
     *
     * @param  array     $data
     * @param  OrderItemInterface $item
     * @return OrderItemInterface
     */
    public function hydrate(array $data, $item)
    {
        $this->checkType($item);

        $item->setUid($data['uid'])
             ->setType($data['type'])
             ->setQuantity($data['quantity'])
             ->setData($data['data'])
             ->setPrice($data['price']);

        return $item;
    }
}
