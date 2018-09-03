<?php
/**
 * User: erick.antunes
 * Date: 25/07/2018
 * Time: 14:20
 */

namespace Paggcerto\Helper;

/**
 * @codeCoverageIgnore
 */
class Error
{
    /**
     * Code of error.
     *
     * @var int|string
     */
    private $code;

    /**
     * Path of error.
     *
     * @var string
     */
    private $path;

    /**
     * Description of error.
     *
     * @var string
     */
    private $description;

    /**
     * Error constructor.
     *
     *
     * @param string $code        unique error identifier.
     * @param string $path        represents the field where the error ocurred.
     * @param string $description error description.
     */
    public function __construct($code = null, $path = null, $description = null)
    {
        $this->code = $code;
        $this->path = $path;
        $this->description = $description;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Returns the unique alphanumeric identifier of the error, ie.: "API-1".
     *
     * @return int|string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Returns the dotted string representing the field where the error ocurred, ie.: "customer.birthDate".
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Returns the error description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Creates an Error array from a json string.
     *
     *
     * @return array
     */
    public function parseErrors($json)
    {
        $error_obj = json_decode($json);
        $errors = [];
        if (!empty($error_obj->errors)) {
            foreach ($error_obj->errors as $error) {
                $errors[] = $error;
            }
        } elseif (!empty($error_obj->error)) {
            $errors[] = new self('', '', $error_obj->error);
        }

        return $errors;
    }
}