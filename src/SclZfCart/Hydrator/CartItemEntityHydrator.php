<?php

namespace SclZfCart\Hydrator;

use SclZfCart\Entity\CartItemInterface as CartItemEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Hydrator for {@see CartItemEntity} objects
 *
 * @author Tom Oram <tom@scl.co.uk>
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
        if (!$entity instanceof CartItemEntity) {
            return array();
        }

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
        if (!$entity instanceof CartItemEntity) {
            return $entity;
        }

        $entity->setUid($data['uid']);
        $entity->setQuantity($data['quantity']);
        $entity->setType($data['type']);
        $entity->setData($data['data']);

        return $entity;
    }
}
