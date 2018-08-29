<?php
/**
 * Created by PhpStorm.
 * User: marcus.vinicius
 * Date: 29/08/2018
 * Time: 11:03
 */

namespace Paggcerto\Exceptions;


use Exception;
use Throwable;

class AuthException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}