<?php

namespace SclZfCart\Service;

use SclZfCart\Cart;
use SclZfCart\Hydrator\CartItemHydrator;
use SclZfCart\Service\CartItemCreatorInterface;
use SclZfCart\Entity\OrderInterface;
use SclZfCart\Hydrator\OrderItemHydrator;
use SclZfCart\Mapper\OrderItemMapperInterface;

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
    protected $cartItemCreator;

    /**
     * @var CartItemHydrator
     */
    protected $cartItemHydrator;

    /**
     * @var OrderItemHydrator
     */
    protected $orderItemHydrator;

    /**
     * Persistence for OrderItem objects.
     * 
     * @var OrderItemMapperInterface
     */
    protected $orderItemMapper;

    /**
     * 
     * @param  CartItemCreatorInterface $cartItemCreator
     * @param  CartItemHydrator         $cartItemHydrator
     * @param  OrderItemHydrator        $orderItemHydrator
     * @param  OrderItemMapper          $orderItemMapper
     */
    public function __construct(
        CartItemCreatorInterface $cartItemCreator,
        CartItemHydrator $cartItemHydrator,
        OrderItemHydrator $orderItemHydrator,
        OrderItemMapperInterface $orderItemMapper
    ) {
        $this->cartItemCreator   = $cartItemCreator;
        $this->cartItemHydrator  = $cartItemHydrator;
        $this->orderItemHydrator = $orderItemHydrator;
        $this->orderItemMapper   = $orderItemMapper;
    }

    /**
     * Copy the contents of the cart into an order.
     *
     * @param  Cart           $cart
     * @param  OrderInterface $order
     */
    public function cartToOrder(Cart $cart, OrderInterface $order)
    {
        $order->reset();

        foreach ($cart->getItems() as $cartItem) {
            $data = $this->cartItemHydrator->extract($cartItem);

            // @todo Maybe add this the the hydrator extract method.
            $data['price'] = $cartItem->getPrice();

            $orderItem = $this->orderItemMapper->create();

            $this->orderItemHydrator->hydrate($data, $orderItem);

            $order->addItem($orderItem);
        }
    }

    /**
     * Transfer the contents of an order into the cart.
     *
     * @param  OrderInterface $order
     * @param  Cart           $cart
     * @param  boolean        $overwrite
     */
    public function orderToCart(OrderInterface $order, Cart $cart, $overwrite = true)
    {
        if (true === $overwrite) {
            $cart->clear();
        }

        foreach ($order->getItems() as $orderItem) {
            $cartItem = $this->getCartItemCreator()
                             ->create($orderItem->getType());

            $data = $this->orderItemHydrator->extract($orderItem);

            $this->cartItemHydrator->hydrate($data, $cartItem);

            $cart->add($cartItem);
        }
    }
}
