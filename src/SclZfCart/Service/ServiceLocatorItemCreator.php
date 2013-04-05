<?php

namespace SclZfCart\Service;

use SclZfCart\CartItemInterface;
use SclZfCart\Service\Exception;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Creates cart items via the ServiceLocator
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class ServiceLocatorItemCreator implements CartItemCreatorInterface
{
    /**
     * The service locator.
     *
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * Initialize with the ServiceLocator.
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $type
     * @return CartItemInterface
     * @throws Exception\DomainException
     */
    public function create($type)
    {
        $cartItem = $this->serviceLocator->get($type);

        if ($cartItem instanceof CartItemInterface) {
            return $cartItem;
        }

        throw new Exception\DomainException(
            sprintf(
                '$cartItem must implement CartItemInterface; got "%s"',
                is_object($cartItem) ? get_class($cartItem) : gettype($cartItem)
            )
        );
    }
}
