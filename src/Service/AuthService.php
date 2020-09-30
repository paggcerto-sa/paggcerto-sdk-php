<?php
/**
 * Author: erick.antunes
 * Date: 28/08/2018
 * Time: 11:28
 * Last Update: astolfo
 * Date: 30/09/2020
 * Time: 12:00 
 */

namespace Paggcerto\Service;

use Paggcerto\Paggcerto;
use Requests;
use stdClass;

class AuthService extends PaggcertoAccountApiService
{
    const AUTH_CREDENTIALS = self::ACCOUNT_VERSION . "/%s/signin/";
    const AUTH_HASH = self::ACCOUNT_VERSION . "/sellers/signin/%s";
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
        $acc->data->bankAccount = $this->getIfSet("bankAccount", $response);
        $acc->data->address = $this->getIfSet("address", $response);
        $acc->data->user = $this->getIfSet("user", $response);
        $acc->data->scope = $this->getIfSet("scope", $response);
        $acc->data->accessGranted = $this->getIfSet("accessGranted", $response);
        $acc->data->accessedByHolder = $this->getIfSet("accessedByHolder", $response);
        $acc->data->expiresIn = $this->getIfSet("expiresIn", $response);

        return $acc->data;
    }

    public function authCredentials($email, $password, $appId = null)
    {
        $path = sprintf(self::AUTH_CREDENTIALS, $appId == null ? Paggcerto::APPLICATION_ID : $appId);
        $credentials = new stdClass();
        $credentials->login = $email;
        $credentials->password = $password;
        $response = $this->httpRequest($path, Requests::POST, $credentials);

        return $this->fillEntity($response);
    }

    public function authHash($hash, $appId = null)
    {
        $path = sprintf(self::AUTH_CREDENTIALS, $appId == null ? Paggcerto::APPLICATION_ID : $appId);
        $path .= $hash;
        $response = $this->httpRequest($path, Requests::POST);

        return $this->fillEntity($response);
    }

    public function authHashByPartner($holderId)
    {
        $path = sprintf(self::AUTH_HASH, $holderId);
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