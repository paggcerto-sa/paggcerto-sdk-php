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
        $listKeys = ["token", "application", "holder", "account", "bankAccount", "address", "user", "scope", "accessGranted", "accessedByHolder"];
        $this->hydratorObject($acc->data,$listKeys,$response);

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