<?php

namespace SclZfCart\CartItem;

/**
 * Interface for items which can have a title and description set on them.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface TitleAwareInterface extends TitleProviderInterface
{
    /**
     * Sets the title of the item.
     *
     * @param  string $title
     * @return void
     */
    public function setTitle($title);

    /**
     * Sets the description of the item.
     *
     * @param  string $description
     * @return void
     */
    public function setDescription($description);
}
