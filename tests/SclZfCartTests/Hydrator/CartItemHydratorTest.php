<?php

namespace SclZfCartTests\Hydrator;

use SclZfCart\Hydrator\CartItemHydrator;

class CartItemHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CartItemHydrator
     */
    protected $hydrator;

    /**
     * Set up the objects to be tested
     */
    protected function setUp()
    {
        $this->hydrator = new CartItemHydrator;
    }

    /**
     * @covers \SclZfCart\Hydrator\CartItemHydrator::extract
     */
    public function testExtract()
    {
        $item = $this->getMock('SclZfCart\CartItemInterface');

        $item->expects($this->once())->method('getUid')->will($this->returnValue('uid'));
        $item->expects($this->once())->method('getQuantity')->will($this->returnValue(4));
        $item->expects($this->once())->method('serialize')->will($this->returnValue('serialized_data'));

        $expected = array(
            'uid'      => 'uid',
            'type'     => get_class($item),
            'quantity' => 4,
            'data'     => 'serialized_data',
        );

        $this->assertEquals($expected, $this->hydrator->extract($item));
    }
}
