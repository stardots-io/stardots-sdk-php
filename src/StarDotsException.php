<?php

namespace StarDots;

/**
 * StarDots SDK Exception
 *
 * Custom exception class for StarDots SDK errors
 */
class StarDotsException extends \Exception
{
    /**
     * Constructor
     *
     * @param string $message Error message
     * @param int $code Error code
     * @param \Exception $previous Previous exception
     */
    public function __construct($message = '', $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
