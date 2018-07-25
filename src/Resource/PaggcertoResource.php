<?php
/**
 * User: erick.antunes
 * Date: 24/07/2018
 * Time: 15:03
 */

namespace Paggcerto\Resource;

use JsonSerializable;
use Paggcerto\Paggcerto;
use stdClass;

abstract class PaggcertoResource implements JsonSerializable
{
    const VERSION = "v1";
    const ACCEPT_VERSION = "application/json";

    protected $paggcerto;
    protected $data;

    public function  __construct(Paggcerto $paggcerto)
    {
        $this->paggcerto = $paggcerto;
        $this->data = new stdClass();
        $this->initialize();
    }

    abstract protected function initialize();

    abstract protected function populate(stdClass $response);

    protected function getIfSet($key, stdClass $data = null)
    {
        if (empty($data)) {
            $data = $this->data;
        }

        if (isset($data->$key)) {
            return $data->$key;
        }
    }
    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}