<?php

namespace SclZfCart\CartItem;

/**
 * Adds basic title aware functionality.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
trait TitleAwareTrait
{
    /**
     * The title.
     *
     * @var string
     */
    protected $title;

    /**
     * The description.
     *
     * @var string
     */
    protected $description;

    /**
     * Get the item title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title of the item.
     *
     * @param  string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = (string) $title;
    }

    /**
     * Get the item description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description of the item.
     *
     * @param  string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = (string) $description;
    }
}
