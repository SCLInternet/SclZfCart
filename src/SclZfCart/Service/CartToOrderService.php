<?php

namespace SclZfCart\Service;

use SclZfCart\Cart;
use SclZfCart\CartItemInterface;
use SclZfCart\Entity\Order;
use SclZfCart\Entity\OrderItem;
use SclZfCart\Hydrator\ItemHydrator;
use SclZfCart\Mapper\OrderItemMapperInterface;
use SclZfCart\Service\CartItemCreatorInterface;

class CartToOrderService
{
    /**
     * @var CartItemCreatorInterface
     */
    private $cartItemCreator;

    /**
     * @var ItemHydrator
     */
    private $itemHydrator;

    /**
     * @var OrderItemMapperInterface
     */
    private $orderItemMapper;

    public function __construct(
        CartItemCreatorInterface $cartItemCreator,
        ItemHydrator $itemHydrator,
        OrderItemMapperInterface $orderItemMapper
    ) {
        $this->cartItemCreator   = $cartItemCreator;
        $this->itemHydrator      = $itemHydrator;
        $this->orderItemMapper   = $orderItemMapper;
    }

    public function cartToOrder(Cart $cart, Order $order)
    {
        $order->reset();

        foreach ($cart->getItems() as $cartItem) {
            $this->addItemToOrder($order, $cartItem);
        }
    }

    /**
     * @param boolean $overwrite
     */
    public function orderToCart(Order $order, Cart $cart, $overwrite = true)
    {
        if (true === $overwrite) {
            $cart->clear();
        }

        foreach ($order->getItems() as $orderItem) {
            $cart->add($this->convertToCartItem($orderItem));
        }
    }

    /**
     * @return CartItemInterface
     */
    public function convertToCartItem(OrderItem $orderItem)
    {
        $cartItem = $this->cartItemCreator->create($orderItem->getType());

        $data = $this->itemHydrator->extract($orderItem);

        return $this->itemHydrator->hydrate($data, $cartItem);
    }

    private function addItemToOrder(Order $order, CartItemInterface $cartItem)
    {
        $data = $this->itemHydrator->extract($cartItem);

        $orderItem = $this->orderItemMapper->create();

        $this->itemHydrator->hydrate($data, $orderItem);

        // @todo Maybe move this into the hydrator
        $orderItem->setType(get_class($cartItem));

        $order->addItem($orderItem);
    }
}
