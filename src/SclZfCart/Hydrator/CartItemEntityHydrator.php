<?php

namespace SclZfCart\Hydrator;

use SclZfCart\Entity\CartItem as CartItemEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Hydrator for {@see CartItemEntity} objects
 *
 * @author Tom Oram <tom@scl.co.uk>
 * @todo Add object type checking
 */
class CartItemEntityHydrator implements HydratorInterface
{
    /**
     * Extracts the data from CartItem entity
     *
     * @param  CartItemEntity $entity
     * @return array
     */
    public function extract($entity)
    {
        return array(
            'uid'      => $entity->getUid(),
            'quantity' => $entity->getQuantity(),
            'type'     => $entity->getType(),
            'data'     => $entity->getData(),
        );
    }

    /**
     * Hydrates the CartItem entity
     *
     * @param  array          $data
     * @param  CartItemEntity $cartItemEntity
     * @return CartItemEntity
     */
    public function hydrate(array $data, $entity)
    {
        $entity->setUid($data['uid'])
               ->setQuantity($data['quantity'])
               ->setType($data['type'])
               ->setData($data['data']);

        return $entity;
    }
}
