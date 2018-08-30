<?php
/**
 * User: erick.antunes
 * Date: 25/07/2018
 * Time: 11:02
 */

namespace Paggcerto\Exceptions;

use RuntimeException;

/**
 * @codeCoverageIgnore
 */
class UnexpectedException extends RuntimeException
{
    public function __construct($previous = null)
    {
        parent::__construct("An unexpected error happened, please contact a Paggcerto", 500, $previous);
    }
}