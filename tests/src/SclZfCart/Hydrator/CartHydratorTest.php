<?php

namespace SclZfCart\Hydrator;

/**
 * Unit test for {@see \SclZfCart\Hydrator\CartHydrator}
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class CartHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CartHydrator
     */
    private $hydrator;

    /**
     * @var \SclZfCart\Storage\CartItemSerializerInterface
     */
    private $serializer;

    /**
     * Prepare the object we'll be using
     */
    protected function setUp()
    {
        $this->serializer = $this->getMock('SclZfCart\Storage\CartItemSerializerInterface');
        $this->hydrator = new CartHydrator($this->serializer);
    }

    /**
     * @covers \SclZfCart\Hydrator\CartHydrator::extract
     */
    public function testExtract()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SclZfCart\Hydrator\CartHydrator::update
     */
    public function testUpdate()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
