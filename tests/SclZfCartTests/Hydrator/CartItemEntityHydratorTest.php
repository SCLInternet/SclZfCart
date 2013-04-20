<?php

namespace SclZfCartTests\Hydrator;

use SclZfCart\Hydrator\CartItemEntityHydrator;

class CartItemEntityHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CartItemEntityHydrator
     */
    protected $hydrator;

    /**
     * Set up the objects to be tested
     */
    protected function setUp()
    {
        $this->hydrator = new CartItemEntityHydrator;
    }

    /**
     * @covers \SclZfCart\Hydrator\CartItemHydrator::extract
     */
    public function testExtract()
    {
        $item = $this->getMock('SclZfCart\Entity\CartItemInterface');

        $item->expects($this->once())->method('getUid')->will($this->returnValue('uid'));
        $item->expects($this->once())->method('getQuantity')->will($this->returnValue(4));
        $item->expects($this->once())->method('getType')->will($this->returnValue('class_type'));
        $item->expects($this->once())->method('getData')->will($this->returnValue('serialized_data'));

        $expected = array(
            'uid'      => 'uid',
            'type'     => 'class_type',
            'quantity' => 4,
            'data'     => 'serialized_data',
        );

        $this->assertEquals($expected, $this->hydrator->extract($item));
    }
}
