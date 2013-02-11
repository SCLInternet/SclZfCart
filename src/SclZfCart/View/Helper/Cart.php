<?php

namespace SclZfCart\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Simple utility plugin for fetching the cart in a plugin.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Cart extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /**
     * The service locator
     *
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
     * Return an instance of the cart.
     *
     * @return \SclZfCart\Cart
     */
    public function __invoke()
    {
        $helperPluginManager = $this->getServiceLocator();
        return $helperPluginManager->getServiceLocator()->get('SclZfCart\Cart');
    }
}
