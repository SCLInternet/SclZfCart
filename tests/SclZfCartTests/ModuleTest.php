<?php

namespace SclZfCartTests;

use SclTest\Zf2\AbstractTestCase;

class ModuleTest extends AbstractTestCase
{
    public function test_item_hydrator_can_be_created()
    {
        $this->assertInstanceOf(
            'SclZfCart\Hydrator\ItemHydrator',
            $this->getHydratorManager()->get('SclZfCart\Hydrator\ItemHydrator')
        );
    }

    public function test_service_manager_can_create_CartToOrderService()
    {
        $this->assertServiceIsInstanceOf(
            'SclZfCart\Service\CartToOrderService',
            'SclZfCart\Service\CartToOrderService'
        );
    }

    private function getHydratorManager()
    {
        return $this->getServiceManager()->get('HydratorManager');
    }
}
