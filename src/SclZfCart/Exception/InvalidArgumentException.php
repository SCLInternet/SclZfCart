<?php

namespace SclZfCart\Exception;

/**
 * Invalid arguement exception class
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class InvalidArgumentException extends \InvalidArgumentException
{
    /**
     * Formats the message.
     * 
     * @param string $expected
     * @param mixed  $got
     * @param string $method
     * @param int    $line
     */
    public function __construct($expected, $got, $method, $line)
    {
        $message = sprintf(
            '%s expected %s on line %d; got "%s"',
            $method,
            $expected,
            $line,
            is_object($got) ? get_class($got) : gettype($got)
        );

        parent::__construct($message);
    }
}
