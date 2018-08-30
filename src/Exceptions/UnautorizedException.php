<?php
/**
 * User: erick.antunes
 * Date: 25/07/2018
 * Time: 11:04
 */

namespace Paggcerto\Exceptions;

use RuntimeException;

/**
 * @codeCoverageIgnore
 */
class UnautorizedException extends RuntimeException
{
    public function __construct($previous = null)
    {
        parent::__construct("Credentials error, confirm your authentication to can make actions ,
         remember, look the environment", 401, $previous);
    }
}