<?php

namespace SclZfCart\Hydrator;

use Zend\Stdlib\Hydrator\HydratorInterface;
use SclZfCart\CartItemInterface;
use SclZfCart\CartItem\TitleAwareInterface;
use SclZfCart\CartItem\DataAwareInterface;

class ItemHydrator implements HydratorInterface
{
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
    protected static $setFields = [
        ['\SclZfCart\CartItem\TitleAwareInterface',     'setTitle',       'title'      ],
        ['\SclZfCart\CartItem\TitleAwareInterface',     'setDescription', 'description'],
        ['\SclZfCart\CartItem\QuantityAwareInterface',  'setQuantity',    'quantity'   ],
        ['\SclZfCart\CartItem\UidAwareInterface',       'setUid',         'uid'        ],
        ['\SclZfCart\CartItem\PriceAwareInterface',     'setPrice',       'price'      ],
        ['\SclZfCart\CartItem\PriceAwareInterface',     'setTax',         'tax'        ],
        ['\SclZfCart\CartItem\UnitPriceAwareInterface', 'setUnitPrice',   'unitPrice'  ],
        ['\SclZfCart\CartItem\UnitPriceAwareInterface', 'setUnitTax',     'unitTax'    ],
        ['\SclZfCart\CartItem\DataAwareInterface',      'setData',        'data'       ],
    ];

    /**
     * Set the value of the object from the entry in the array using the provided
     * setter method providing that the object is an instance of $interface and
     * $data[$key] exists.
     *
     * @param  string $interface
     * @param  object $object
     * @param  string $method
     * @param  array  $data
     * @param  string $key
     * @return object
     */
    private function conditionalSet($interface, $object, $method, array $data, $key)
    {
        if (!$object instanceof $interface) {
            return;
        }

        if (!isset($data[$key])) {
            return;
        }

        $object->$method($data[$key]);

        return $object;
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof CartItemInterface) {
            return $object;
        }

        foreach (self::$setFields as $fieldParams) {
            $this->conditionalSet(
                // Interface name
                $fieldParams[0],
                $object,
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
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if (!$object instanceof CartItemInterface) {
            return [];
        }

        $data = [
            'title'       => $object->getTitle(),
            'description' => $object->getDescription(),
            'quantity'    => $object->getQuantity(),
            'uid'         => $object->getUid(),
            'price'       => $object->getPrice(),
            'tax'         => $object->getTax(),
            'unitPrice'   => $object->getUnitPrice(),
            'unitTax'     => $object->getUnitTax(),
        ];

        if ($object instanceof DataAwareInterface) {
            $data['data'] = $object->getData();
        }

        return $data;
    }
}
