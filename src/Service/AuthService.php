<?php
/**
 * User: erick.antunes
 * Date: 28/08/2018
 * Time: 11:28
 */

namespace Paggcerto\Service;


use Paggcerto\Paggcerto;
use Requests;
use stdClass;

class AuthService extends PaggcertoAccountApiService
{
    const AUTH_CREDENTIALS = self::ACCOUNT_VERSION . "/%s/signin/";
    const WHOAMI = self::ACCOUNT_VERSION . "/whoami";


    public function whoAmI()
    {
        $response = $this->httpRequest(self::WHOAMI, Requests::GET);

        return $this->fillEntity($response);
    }

    /**
     * @param stdClass $response
     * @return mixed
     */
    protected function fillEntity(stdClass $response)
    {
        $acc = clone $this;
        $acc->data = new stdClass();
        $acc->data->token = $this->getIfSet("token", $response);
        $acc->data->application = $this->getIfSet("application", $response);
        $acc->data->holder = $this->getIfSet("holder", $response);
        $acc->data->account = $this->getIfSet("account", $response);
        $acc->data->user = $this->getIfSet("user", $response);
        $acc->data->scope = $this->getIfSet("scope", $response);
        $acc->data->accessGranted = $this->getIfSet("accessGranted", $response);
        $acc->data->accessedByHolder = $this->getIfSet("accessedByHolder", $response);

        return $acc->data;
    }

    public function authCredentials($email, $password)
    {
        $path = sprintf(self::AUTH_CREDENTIALS, Paggcerto::APPLICATION_ID);
        $credentials = new stdClass();
        $credentials->login = $email;
        $credentials->password = $password;
        $response = $this->httpRequest($path, Requests::POST, $credentials);

        return $this->fillEntity($response);
    }

    public function authHash($hash)
    {
        $path = sprintf(self::AUTH_CREDENTIALS, Paggcerto::APPLICATION_ID);
        $path .= $hash;
        $response = $this->httpRequest($path, Requests::POST);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    protected function init()
    {
        $this->data = new stdClass();
    }

}