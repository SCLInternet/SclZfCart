<?php

namespace SclZfCartTests\Mapper\Doctrine;

use SclBusiness\Mapper\Doctrine\MiscServiceMapper;

class CartItemMapperTest extends AbstractDatabaseTestCase
{
    private $mapper;

    public function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/../../../testdata.yml'
        );
    }

    /**
     * Set up the instance to be tested.
     *
     * @return void
     */
    protected function setUpTestCase()
    {
        $this->mapper = \TestBootstrap::getApplication()
                            ->getServiceManager()
                            ->get('SclZfCart\Mapper\DoctrineCartItemMapper');
    }

    public function test_implements_interface()
    {
        $this->assertInstanceOf(
            'SclZfCart\Mapper\CartItemMapperInterface',
            $this->mapper
        );
    }

    public function test_findById_can_create_price_objects()
    {
        $item = $this->mapper->findById(1);

        $price = $item->getPrice();
    }
}
