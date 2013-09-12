<?php

namespace SclZfCart\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Simple utility plugin for fetching the cart in a plugin.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Cart extends AbstractPlugin
{
    /**
     * Get the service locator.
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    private function getServiceLocator()
    {
        $controller = $this->getController();

        return $controller->getServiceLocator();
    }

    /**
     * Return an instance of the cart.
     *
     * @return \SclZfCart\Cart
     */
    public function __invoke()
    {
        return $this->getServiceLocator()->get('SclZfCart\Cart');
    }
}
