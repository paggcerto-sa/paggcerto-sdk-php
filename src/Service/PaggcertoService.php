<?php
/**
 * User: erick.antunes
 * Date: 24/07/2018
 * Time: 15:03
 */

namespace Paggcerto\Service;

use JsonSerializable;
use Paggcerto\Exceptions\UnautorizedException;
use Paggcerto\Exceptions\UnexpectedException;
use Paggcerto\Paggcerto;
use Requests;
use Requests_Exception;
use stdClass;

abstract class PaggcertoService implements JsonSerializable
{
    const ACCOUNT_VERSION = "v2";
    const PAYMENTS_VERSION = "v2";
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

    protected function httpRequest($path, $method, $payload = null, $headers = [])
    {
        $http_sess = $this->paggcerto->getSession();
        $body = null;
        if ($payload !== null) {
            $body = json_encode($payload, JSON_UNESCAPED_SLASHES);
            if ($body) {    // if it's json serializable
                $headers['Content-Type'] = 'application/json';
            } else {
                $body = null;
            }
        }

        try {
            $http_response = $http_sess->request($path, $headers, $body, $method);
        } catch (Requests_Exception $e) {
            throw new UnexpectedException($e);
        }

        $code = $http_response->status_code;
        $response_body = $http_response->body;
        if ($code >= 200 && $code < 300) {
            return json_decode($response_body);
        } elseif ($code == 401) {
            throw new UnautorizedException();
        } elseif ($code >= 400 && $code <= 499) {
            $errors = Error::parseErrors($response_body);

            throw new ValidationException($code, $errors);
        }

        throw new UnexpectedException();
    }

    public function getRequest($path)
    {
        $response = $this->httpRequest($path, Requests::GET);

        if (is_array($response)) {
            $response = (object) $response;
        }

        return $this->populate($response);
    }
    public function createRequest($path)
    {
        $response = $this->httpRequest($path, Requests::POST, $this);

        return $this->populate($response);
    }

    public function updateRequest($path)
    {
        $response = $this->httpRequest($path, Requests::PUT, $this);

        return $this->populate($response);
    }

    public function deleteRequest($path)
    {
        return $response = $this->httpRequest($path, Requests::DELETE);
    }

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