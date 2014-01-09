<?php

namespace SclZfCartTests\Hydrator;

use SclZfCart\Hydrator\ItemHydrator;
use SCL\Currency\TaxedPriceFactory;

/**
 * Unit tests for {@see ItemHydrator}.
 *
 * @covers SclZfCart\Hydrator\ItemHydrator
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class ItemHydratorTest extends \PHPUnit_Framework_TestCase
{
    const TEST_TITLE       = 'Test title';
    const TEST_DESCRIPTION = 'Test description';
    const TEST_QUANTITY    = 5;
    const TEST_UID         = 'abc123';
    const TEST_PRICE       = 50;
    const TEST_TAX         = 10;
    const TEST_UNIT_PRICE  = 10;
    const TEST_UNIT_TAX    = 2;
    const TEST_DATA        = 'random serialized test data';

    private $hydrator;

    private $testItem;

    private $priceFactory;

    /**
     * Set up the instance to be tested.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->priceFactory = TaxedPriceFactory::createDefaultInstance();

        $this->hydrator = new ItemHydrator($this->priceFactory);

        $this->createTestItem();
    }

    /*
     * extract()
     */

    public function test_extract_returns_array()
    {
       $this->assertInternalType('array', $this->hydrator->extract(new \stdClass));
    }

    public function test_extract_returns_empty_array_for_unknown_object()
    {
        $this->assertEmpty($this->hydrator->extract(new \stdClass()));
    }

    /**
     * @dataProvider extractedFieldProvider
     */
    public function test_extract_contains($key, $expected)
    {
        $result = $this->hydrator->extract($this->testItem);

        $this->assertArrayHasKey($key, $result);

        $this->assertEquals($expected, $result[$key]);
    }

    public function test_extract_returns_data_if_object_implements_DataAwareInterface()
    {
        $object = $this->createMockItemWithOneReturningMethod('getData', self::TEST_DATA);

        $result = $this->hydrator->extract($object);

        $this->assertEquals(self::TEST_DATA, $result['data']);
    }

    public function test_extract_extracts_price_into_seperate_fields()
    {
        $price = $this->priceFactory->createFromValues(10.10, 2.2);

        $object = $this->createMockItemWithOneReturningMethod('getPrice', $price);

        $data = $this->hydrator->extract($object);

        $this->assertArrayValueByKey(10.10, $data, 'price');
        $this->assertArrayValueByKey(2.2, $data, 'tax');
    }

    public function test_extract_extracts_unit_price_into_seperate_fields()
    {
        $price = $this->priceFactory->createFromValues(10.10, 2.2);

        $object = $this->createMockItemWithOneReturningMethod('getUnitPrice', $price);

        $data = $this->hydrator->extract($object);

        $this->assertArrayValueByKey(10.10, $data, 'unitPrice');
        $this->assertArrayValueByKey(2.2, $data, 'unitTax');
    }


    /*
     * hydrate()
     */

    public function test_hydrate_returns_the_object_passed_in()
    {
        $this->assertSame(
            $this->testItem,
            $this->hydrator->hydrate([], $this->testItem)
        );
    }

    public function test_hydrate_doesnt_alter_object_if_no_data_provided()
    {
        // No methods are mocked so any calls to the item would be an error
        $item = $this->getMock('SclZfCart\CartItemInterface', []);

        $this->hydrator->hydrate([], $item);
    }

    public function test_hydrate_converts_price_and_tax_to_price_object()
    {
        $item = $this->getMock('SclZfCartTests\TestAssets\FullyLoadedCartItemInterface');

        $price = $this->priceFactory->createFromValues(50, 10);

        $item->expects($this->once())
             ->method('setPrice')
             ->with($this->equalTo($price));

        $this->hydrator->hydrate(['price' => 50, 'tax' => 10], $item);
    }

    public function test_hydrate_converts_unit_price_and_tax_to_price_object()
    {
        $item = $this->getMock('SclZfCartTests\TestAssets\FullyLoadedCartItemInterface');

        $price = $this->priceFactory->createFromValues(50, 10);

        $item->expects($this->once())
             ->method('setUnitPrice')
             ->with($this->equalTo($price));

        $this->hydrator->hydrate(['unitPrice' => 50, 'unitTax' => 10], $item);
    }

    /**
     * @dataProvider hydrateMembersProvider
     *
     * @param string $field
     * @param mixed  $testValue
     * @param string $setMethod
     */
    public function test_object_value_is_set_if_data_is_provided($field, $testValue, $setMethod)
    {
        $testItem = $this->getMock('SclZfCartTests\TestAssets\FullyLoadedCartItemInterface');

        $testItem->expects($this->once())
                 ->method($setMethod)
                 ->with($this->equalTo($testValue));

        $this->hydrator->hydrate([$field => $testValue], $testItem);
    }

    /**
     * @dataProvider hydrateMembersProvider
     *
     * @param string $field
     * @param mixed  $testValue
     */
    public function test_object_value_is_not_set_if_correct_interface_is_not_implemented($field, $testValue)
    {
        $item = $this->getMock('SclZfCart\CartItemInterface');

        $this->hydrator->hydrate([$field => $testValue], $item);
    }

    public function test_hydrator_returns_the_unmodified_object_if_not_an_instance_of_CartItemInterface()
    {
        $item = new \stdClass();

        $this->assertSame(
            $item,
            $this->hydrator->hydrate(['title' => self::TEST_TITLE], $item)
        );
    }

    /*
     * Data providers.
     */

    /**
     * extractedFieldProvider
     *
     * @return array
     */
    public function extractedFieldProvider()
    {
        return [
            ['title',       self::TEST_TITLE      ],
            ['description', self::TEST_DESCRIPTION],
            ['quantity',    self::TEST_QUANTITY   ],
            ['uid',         self::TEST_UID        ],
        ];
    }

    /**
     * hydrateMembersProvider
     *
     * @return array
     */
    public function hydrateMembersProvider()
    {
        return [
            ['title',       self::TEST_TITLE,       'setTitle'      ],
            ['description', self::TEST_DESCRIPTION, 'setDescription'],
            ['quantity',    self::TEST_QUANTITY,    'setQuantity'   ],
            ['uid',         self::TEST_UID,         'setUid'        ],
            ['data',        self::TEST_DATA,        'setData'       ],
        ];
    }

    /*
     * Private methods
     */

    /**
     * @param mixed $expected
     * @param array $array
     * @param mixed $key
     */
    private function assertArrayValueByKey($expected, array $array, $key)
    {
        $this->assertArrayHasKey($key, $array);
        $this->assertEquals($expected, $array[$key]);
    }

    /**
     * @param string $method
     * @param mixed  $value
     *
     * @return CartItemInterface
     */
    private function createMockItemWithOneReturningMethod($method, $value)
    {
        $item = $this->getMock('SclZfCartTests\TestAssets\FullyLoadedCartItemInterface');

        $item->expects($this->once())
               ->method($method)
               ->will($this->returnValue($value));

        return $item;
    }

    private function createTestItem()
    {
        $this->testItem = $this->getMock('SclZfCart\CartItemInterface');

        $this->testItem
             ->expects($this->any())
             ->method('getTitle')
             ->will($this->returnValue(self::TEST_TITLE));

        $this->testItem
             ->expects($this->any())
             ->method('getDescription')
             ->will($this->returnValue(self::TEST_DESCRIPTION));

        $this->testItem
             ->expects($this->any())
             ->method('getQuantity')
             ->will($this->returnValue(self::TEST_QUANTITY));

        $this->testItem
             ->expects($this->any())
             ->method('getUid')
             ->will($this->returnValue(self::TEST_UID));

        $this->testItem
             ->expects($this->any())
             ->method('getPrice')
             ->will($this->returnValue(self::TEST_PRICE));

        $this->testItem
             ->expects($this->any())
             ->method('getTax')
             ->will($this->returnValue(self::TEST_TAX));

        $this->testItem
             ->expects($this->any())
             ->method('getUnitPrice')
             ->will($this->returnValue(self::TEST_UNIT_PRICE));

        $this->testItem
             ->expects($this->any())
             ->method('getUnitTax')
             ->will($this->returnValue(self::TEST_UNIT_TAX));
    }
}
