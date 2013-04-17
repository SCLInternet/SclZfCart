<?php

namespace SclZfCart\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Doctrine implementation of the the OrderInterface
 *
 * @ORM\Entity
 * @ORM\Table(name="cart_order_item")
 */
class DoctrineOrderItem implements OrderItemInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var DoctrineOrder
     * @ORM\ManyToOne(targetEntity="SclZfCart\Entity\DoctrineOrder", inversedBy="items")
     */
    protected $order;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @todo Try and get rid of this.
     */
    protected $uid;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    protected $price;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $data;

    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     *
     * @param  int $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Sets the value for order.
     *
     * @param  DoctrineOrder $order
     * @return self
     */
    public function setOrder(DoctrineOrder $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * {@inheritDoc}
     *
     * @param  int $quantity
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $uid
     * @return self
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * {@inheritDoc}
     *
     * @param  float $price
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritDoc}
     *
     * @param  string $data
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
