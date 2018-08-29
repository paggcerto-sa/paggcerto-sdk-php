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
use Paggcerto\Exceptions\ValidationException;
use Paggcerto\Paggcerto;
use Requests;
use Requests_Exception;
use stdClass;

/**
 * Class PaggcertoService
 * @package Paggcerto\Service
 */
abstract class PaggcertoService implements JsonSerializable
{
    const ACCOUNT_VERSION = "v2";
    const PAYMENTS_VERSION = "v2";
    const ACCEPT_VERSION = "application/json";

    protected $paggcerto;
    protected $data;

    private $routeParams = [];
    private $queryString = [];
    private $path;

    /**
     * PaggcertoService constructor.
     * @param Paggcerto $paggcerto
     */
    public function __construct(Paggcerto $paggcerto)
    {
        $this->paggcerto = $paggcerto;
        $this->data = new stdClass();
        $this->init();
    }

    /**
     * @return mixed
     */
    abstract protected function init();

    /**
     * @param array $routeParams
     * @param array $queryString
     * @param $path
     * @return mixed
     */
    public function getRequest($routeParams = [], $queryString = [], $path)
    {
        $this->routeParams = $routeParams;
        $this->queryString = $queryString;
        $this->path = $path;

        $response = $this->httpRequest($this->mountUrl(), Requests::GET);

        if (is_array($response)) {
            // @codeCoverageIgnoreStart
            $response = (object)$response;
            // @codeCoverageIgnoreEnd
        }

        return $this->fillEntity($response);
    }

    /**
     * @param $path
     * @param $method
     * @param null $payload
     * @param array $headers
     * @return mixed
     */
    protected function httpRequest($path, $method, $payload = null, $headers = [])
    {
        $http_sess = $this->paggcerto->getSession();
        $body = null;
        if ($payload !== null) {
            $body = json_encode($payload, JSON_UNESCAPED_SLASHES);
            if ($body) {
                $headers['Content-Type'] = 'application/json';
            }
        }

        try {
            $http_response = $http_sess->request($path, $headers, $body, $method);
        } catch (Requests_Exception $e) {
            throw new UnexpectedException($e);
        }

        $code = $http_response->status_code;
        $response_body = $http_response->body;
        // @codeCoverageIgnoreStart
        if ($code >= 200 && $code < 300) {
            return json_decode($response_body);
        } elseif ($code == 401) {
            throw new UnautorizedException();
        } elseif ($code >= 400 && $code <= 499) {
            $errors = (new Error())->parseErrors($response_body);

            throw new ValidationException($code, $errors);
        }

        throw new UnexpectedException();
        // @codeCoverageIgnoreEnd
    }

    private function mountUrl()
    {
        if (count($this->routeParams) > 0) {
            foreach ($this->routeParams as $param) {
                $this->path .= "/{$param}";
            }
        }

        if (count($this->queryString) > 0) {
            $count = 0;

            foreach ($this->queryString as $key => $value) {
                if ($count == 0) {
                    $this->path .= "?{$key}={$value}";
                    $count++;
                    continue;
                }
                $this->path .= "&{$key}={$value}";
                $count++;
            }
        }

        return $this->path;
    }

    /**
     * @param stdClass $response
     * @return mixed
     */
    abstract protected function fillEntity(stdClass $response);

    /**
     * @param $path
     * @return mixed
     */
    public function createRequest($path)
    {
        $response = $this->httpRequest($path, Requests::POST, $this);

        return $this->fillEntity($response);
    }

    /**
     * @param $path
     * @return mixed
     */
    public function updateRequest($path)
    {
        $response = $this->httpRequest($path, Requests::PUT, $this);

        return $this->populate($response);
    }

    /**
     * @param $path
     * @return mixed
     */
    public function deleteRequest($path)
    {
        return $response = $this->httpRequest($path, Requests::DELETE);
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

    /**
     * @param $key
     * @param stdClass|null $data
     * @return mixed
     */
    protected function getIfSet($key, stdClass $data = null)
    {
        if (empty($data)) {
            // @codeCoverageIgnoreStart
            $data = $this->data;
            // @codeCoverageIgnoreEnd
        }

        if (isset($data->$key)) {
            return $data->$key;
        }
    }
}