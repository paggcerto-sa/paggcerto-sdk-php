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
        parent::__construct("Erro de credenciais, confirme se sua autenticação pode realizar a ação desejada,
         lembre-se dos ambientes distintos", 401, $previous);
    }
}