<?php

namespace SclZfCart\Hydrator;

use SclZfCart\Cart;
use SclZfCart\CartItem;
use SclZfCart\Entity\CartItem as CartItemEntity;
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
     * @param Cart $cart
     *
     * @return CartItemEntity[]
     */
    public function extract(Cart $cart)
    {
        $data = array();

        /* @var $item \SclZfCart\CartItem */
        foreach ($cart->getItems() as $item) {
            $product = $item->getProduct();

            $data[$product->getUid()] = array(
                'quantity'    => $item->getQuantity(),
                'uid'         => $product->getUid(),
                'productType' => get_class($product),
                'productData' => serialize($product)
            );
        }

        return $data;
    }

    /**
     * @param CartItemEntity[] $data
     * @param Cart             $cart
     *
     * @throws \Exception
     */
    public function hydrate(array $data, Cart $cart)
    {
        $cart->clear();

        foreach ($data as $itemEntity) {
            if (!$itemEntity instanceof CartItemEntity) {
                throw new \Exception(
                    sprintf(
                        'Expected instance of \SclZfCart\Entity\CartItem; got "%s"',
                        is_object($itemEntity) ? get_class($itemEntity) : gettype($itemEntity)
                    )
                );
            }

            $product = unserialize($itemEntity->getProductData());

            $cart->add($product, $itemEntity->getQuantity());
        }
    }
}
