<?php
/**
 * User: erick.antunes
 * Date: 24/07/2018
 * Time: 11:49
 */

namespace Paggcerto\Auth;

use JsonSerializable;
use Paggcerto\Contracts\Authentication;
use Paggcerto\Paggcerto;
use Requests_Session;

class ToConnect implements JsonSerializable
{
    private $oauth_token = "api/v2/%s/signin";
    private $paggcertoAuthentication;
    private $applicationNumber;
    private $endpoint;
    private $session;

    public function __construct(Authentication $paggcertoAuthentication, $applicationNumber,
                                $endpoint = Paggcerto::ACCOUNT_ENDPOINT_SANDBOX)
    {
        $this->paggcertoAuthentication = $paggcertoAuthentication;
        $this->applicationNumber = $applicationNumber;
        $this->endpoint = sprintf($this->oauth_token, $this->applicationNumber);
    }

    public function createNewSession($timeout = 30.0, $connect_timeout = 30.0)
    {
        $user_agent = sprintf('%s/%s (+https://github.com/paggcerto-sa/paggcerto-sdk-php/)', Paggcerto::CLIENT,
            Paggcerto::CLIENT_VERSION);
        $sess = new Requests_Session($this->endpoint);
        $sess->options['auth'] = $this->paggcertoAuthentication;
        $sess->options['timeout'] = $timeout;
        $sess->options['connect_timeout'] = $connect_timeout;
        $sess->options['useragent'] = $user_agent;
        $this->session = $sess;

        return $sess;
    }

    /**
     * Returns the http session created.
     *
     * @return Requests_Session
     */
    public
    function getSession()
    {
        return $this->session;
    }

    public
    function getAuthUrl($endpoint = null)
    {
        if ($endpoint !== null) {
            $this->endpoint = $endpoint;
        }
        return $endpoint;
    }

    public
    function authorize()
    {
        $urlPath = $this->endpoint . $this->oauth_token;
        $headers = ["Content-Type" => "application/json"];
        $body = [

        ];
    }

    public
    function getApplicationNumber()
    {
        return $this->applicationNumber;
    }

    function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}