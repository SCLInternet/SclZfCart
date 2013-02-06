<?php

namespace SclZfCart\Entity;

use DateTime;

/**
 * Entity class for storing a cart to the database
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Cart
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var DateTime
     */
    protected $lastUpdated;

    public function __construct()
    {
        $this->timestamp = new DateTime();
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Cart
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param DateTime $lastUpdated
     * @return Cart
     */
    public function setLastUpdated(DateTime $lastUpdated)
    {
        $this->lastUpdated = (int) $lastUpdated;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }
}
