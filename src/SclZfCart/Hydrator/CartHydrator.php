<?php

namespace SclZfCart\Hydrator;

use SclZfCart\Cart;
use SclZfCart\Entity\CartItem as CartItemEntity;
use SclZfCart\Exception\InvalidArgumentException;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Hydrator to extract and hydrator a cart's contents.
 *
 * @author Tom Oram <tom@scl.co.uk>
 *
 * @todo Consider using a product hydrator
 */
class CartHydrator implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /** 
     * @var CartItemSerializerInterface
     */
    private $serializer;

    /**
     * {@inheritDoc}
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * {@inheritDoc}
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @return CartItemInterface
     */
    protected function getItemSerializer()
    {
        if (null === $this->serializer) {
            $this->serializer = $this->getServiceLocator()
                ->get('SclZfCart\Storage\CartItemSerializer');
        }

        return $this->serializer;
    }

    /**
     * @param Cart $cart
     * @return CartItemEntity[]
     */
    public function extract(Cart $cart)
    {
        $data = array();

        /* @var $item \SclZfCart\CartItem */
        foreach ($cart->getItems() as $item) {

            $data[$item->getUid()] = array(
                'uid'  => $item->getUid(),
                'data' => $this->getItemSerializer()->serialize($item)
            );
        }

        return $data;
    }

    /**
     * @param CartItemEntity[] $data
     * @param Cart             $cart
     * @throws InvalidArguementException
     */
    public function hydrate(array $data, Cart $cart)
    {
        $cart->clear();

        foreach ($data as $itemEntity) {
            if (!$itemEntity instanceof CartItemEntity) {
                throw new InvalidArgumentException(
                    '\SclZfCart\Entity\CartItem',
                    $itemEntity,
                    __CLASS__ . '::' . __METHOD__,
                    __LINE__
                );
            }

            $item = $this->getItemSerializer()->unserialize($itemEntity->getData());

            $cart->add($item);
        }
    }
}
