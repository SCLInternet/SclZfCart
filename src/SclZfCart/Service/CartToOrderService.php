<?php

namespace SclZfCart\Service;

use SclZfCart\Cart;
use SclZfCart\CartItemInterface;
use SclZfCart\Entity\OrderInterface;
use SclZfCart\Entity\OrderItemInterface;
use SclZfCart\Hydrator\ItemHydrator;
use SclZfCart\Mapper\OrderItemMapperInterface;
use SclZfCart\Service\CartItemCreatorInterface;

/**
 * Provides methods to fill an Order entity from a Cart, or fill a Cart from an Order entity.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
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

    /**
     * @param CartItemCreatorInterface $cartItemCreator
     * @param ItemHydrator             $itemHydrator
     * @param OrderItemMapper          $orderItemMapper
     */
    public function __construct(
        CartItemCreatorInterface $cartItemCreator,
        ItemHydrator $itemHydrator,
        OrderItemMapperInterface $orderItemMapper
    ) {
        $this->cartItemCreator   = $cartItemCreator;
        $this->itemHydrator      = $itemHydrator;
        $this->orderItemMapper   = $orderItemMapper;
    }

    /**
     * Copy the contents of the cart into an order.
     *
     * @param Cart           $cart
     * @param OrderInterface $order
     */
    public function cartToOrder(Cart $cart, OrderInterface $order)
    {
        $order->reset();

        foreach ($cart->getItems() as $cartItem) {
            $this->addItemToOrder($order, $cartItem);
        }
    }

    /**
     * Transfer the contents of an order into the cart.
     *
     * @param OrderInterface $order
     * @param Cart           $cart
     * @param boolean        $overwrite
     */
    public function orderToCart(OrderInterface $order, Cart $cart, $overwrite = true)
    {
        if (true === $overwrite) {
            $cart->clear();
        }

        foreach ($order->getItems() as $orderItem) {
            $cart->add($this->convertToCartItem($orderItem));
        }
    }

    /**
     * Convert a order item entity into a cart item.
     *
     * @param OrderItemInterface $orderItem
     *
     * @return CartItemInterface
     */
    public function convertToCartItem(OrderItemInterface $orderItem)
    {
        $cartItem = $this->cartItemCreator->create($orderItem->getType());

        $data = $this->itemHydrator->extract($orderItem);

        return $this->itemHydrator->hydrate($data, $cartItem);
    }

    private function addItemToOrder(OrderInterface $order, CartItemInterface $cartItem)
    {
        $data = $this->itemHydrator->extract($cartItem);

        $orderItem = $this->orderItemMapper->create();

        $this->itemHydrator->hydrate($data, $orderItem);

        // @todo Maybe move this into the hydrator
        $orderItem->setType(get_class($cartItem));

        $order->addItem($orderItem);
    }
}
