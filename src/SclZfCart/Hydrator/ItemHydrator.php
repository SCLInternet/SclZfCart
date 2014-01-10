<?php

namespace SclZfCart\Hydrator;

use SCL\Currency\TaxedPrice;
use SCL\Currency\TaxedPriceFactory;
use SclZfCart\CartItemInterface;
use SclZfCart\CartItem\DataAwareInterface;
use SclZfCart\CartItem\TitleAwareInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

class ItemHydrator implements HydratorInterface
{
    /**
     * @var TaxedPriceFactory
     */
    private $priceFactory;

    /**
     * List of fields to be set on the object.
     *
     * Contains a sub array for each field containing the following values:
     * index 0 - The name of the interface which must be implemented to accept this value.
     * index 1 - The set method used to set the value.
     * index 2 - The key in the data array which should hold the value.
     *
     * @var array
     */
    private static $setFields = [
        ['\SclZfCart\CartItem\TitleAwareInterface',     'setTitle',       'title'      ],
        ['\SclZfCart\CartItem\TitleAwareInterface',     'setDescription', 'description'],
        ['\SclZfCart\CartItem\QuantityAwareInterface',  'setQuantity',    'quantity'   ],
        ['\SclZfCart\CartItem\UidAwareInterface',       'setUid',         'uid'        ],
        ['\SclZfCart\CartItem\PriceAwareInterface',     'setPrice',       'price'      ],
        ['\SclZfCart\CartItem\UnitPriceAwareInterface', 'setUnitPrice',   'unitPrice'  ],
        ['\SclZfCart\CartItem\DataAwareInterface',      'setData',        'data'       ],
    ];

    public function __construct(TaxedPriceFactory $priceFactory)
    {
        $this->priceFactory = $priceFactory;
    }

    /**
     * @param CartItemInterface $object
     *
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof CartItemInterface) {
            return $object;
        }

        $this->convertValuesToPriceObject($data, 'price', 'tax');
        $this->convertValuesToPriceObject($data, 'unitPrice', 'unitTax');

        foreach (self::$setFields as $fieldParams) {
            $this->setIfImplementsInterfaceAndValueExists(
                $object,
                // Interface name
                $fieldParams[0],
                // $object set method
                $fieldParams[1],
                $data,
                // $data value key
                $fieldParams[2]
            );
        }

        return $object;
    }

    /**
     * @param CartItemInterface $object
     *
     * @return array
     */
    public function extract($object)
    {
        echo get_class($object);
        if (!$object instanceof CartItemInterface) {
            return [];
        }
        echo "BOOOM!";

        $data = [
            'title'       => $object->getTitle(),
            'description' => $object->getDescription(),
            'quantity'    => $object->getQuantity(),
            'uid'         => $object->getUid(),
        ];

        $data = array_merge(
            $data,
            $this->extractTaxedPriceObject($object->getPrice(), 'price', 'tax'),
            $this->extractTaxedPriceObject($object->getUnitPrice(), 'unitPrice', 'unitTax')
        );

        if ($object instanceof DataAwareInterface) {
            $data['data'] = $object->getData();
        }

        echo "EXTRAAAAAAAAAAAAAAAACT\n";
        var_dump($data);
        return $data;
    }

    /**
     * @param string $priceName
     * @param string $taxName
     */
    private function convertValuesToPriceObject(array &$data, $priceName, $taxName)
    {
        if (!isset($data[$priceName])) {
            return;
        }

        $data[$priceName] = $this->priceFactory->createFromValues(
            $data[$priceName],
            $data[$taxName]
        );

        unset($data[$taxName]);
    }

    /**
     * @param string $interface
     * @param object $object
     * @param string $method
     * @param array  $data
     * @param string $key
     *
     * @return object
     */
    private function setIfImplementsInterfaceAndValueExists($object, $interface, $setterMethod, array $data, $key)
    {
        if (!$object instanceof $interface) {
            return;
        }

        if (!isset($data[$key])) {
            return;
        }

        $object->$setterMethod($data[$key]);

        return $object;
    }

    /**
     * @param TaxedPrice $price
     * @param string     $priceName
     * @param string     $taxName
     *
     * @return float[]
     */
    private function extractTaxedPriceObject($price, $priceName, $taxName)
    {
        if (!$price instanceof TaxedPrice) {
            return [];
        }

        return [
            $priceName => $price->getAmount()->getValue(),
            $taxName   => $price->getTax()->getValue()
        ];
    }
}
