<?php
/**
 * User: erick.antunes
 * Date: 25/07/2018
 * Time: 14:21
 */

namespace Paggcerto\Exceptions;

use RuntimeException;

/**
 * @codeCoverageIgnore
 */
class ValidationException extends RuntimeException
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var Error[]
     */
    private $errors;

    /**
     * ValidationException constructor.
     *
     * Indicates that an invalid value was passed.
     *
     * @param int $statusCode
     * @param Error[] $errors
     */
    public function __construct($statusCode, $errors)
    {
        $this->errors = $errors;
        $this->statusCode = $statusCode;

        parent::__construct($this->toString(), $this->statusCode);
    }

    /**
     * Convert error variables in string.
     *
     * @return string
     */
    public function toString()
    {
        $template = "[$this->statusCode] The following errors ocurred:\n%s";
        $temp_list = '';
        foreach ($this->errors as $error) {

            if (!is_string($error)) {
                $temp_list .= $error->getDescription() . "\n";
                continue;
            }

            $temp_list .= "${error}\n";
        }

        return sprintf($template, $temp_list);
    }

    /**
     * Returns the http status code ie.: 400.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Returns the list of errors returned by the API.
     *
     * @return Error[]
     *
     */
    public function getErrors()
    {
        return $this->errors;
    }
}