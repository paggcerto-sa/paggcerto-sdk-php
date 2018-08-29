<?php
/**
 * User: erick.antunes
 * Date: 28/08/2018
 * Time: 17:50
 */

namespace Paggcerto\Service;


use Requests;
use stdClass;

class RoleService extends PaggcertoService
{
    const ROLE_URI = self::ACCOUNT_VERSION . "/roles";

    public function setRoleId($roleId)
    {
        $this->data->roleId = $roleId;

        return $this;
    }

    public function setName($name)
    {
        $this->data->name = $name;

        return $this;
    }

    public function setActive($active)
    {
        $this->data->active = $active;

        return $this;
    }

    public function createRole()
    {
        $response = $this->httpRequest(self::ROLE_URI, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    public function updateRole()
    {
        $urlPath = self::ROLE_URI . "/{$this->data->roleId}";
        $response = $this->httpRequest($urlPath, Requests::PUT, $this->data);

        return $this->fillEntity($response);
    }

    public function rolesList()
    {
        $response = $this->httpRequest(self::ROLE_URI, Requests::GET);

        return $this->fillEntity($response);
    }

    public function searchRole()
    {
        $urlPath = self::ROLE_URI . "/{$this->data->roleId}";
        $response = $this->httpRequest($urlPath, Requests::GET);

        return $this->fillEntity($response);
    }

    public function deactivateRole()
    {
        $urlPath = self::ROLE_URI . "/{$this->data->roleId}/deactivate";
        $response = $this->httpRequest($urlPath, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    protected function init()
    {
        $this->data = new stdClass();
    }

    /**
     * @param stdClass $response
     * @return mixed
     */
    protected function fillEntity(stdClass $response)
    {
        $roleReturn = clone $this;
        $roleReturn-> data = new stdClass();
        $roleReturn->data->id = $this->getIfSet("id", $response);
        $roleReturn->data->name = $this->getIfSet("name", $response);
        $roleReturn->data->active = $this->getIfSet("active", $response);
        $roleReturn->data->createdAt = $this->getIfSet("createdAt", $response);
        $roleReturn->data->totalUsers = $this->getIfSet("totalUsers", $response);
        $roleReturn->data->scopes = $this->getIfSet("scopes", $response);
        $roleReturn->data->roles = $this->getIfSet("roles", $response);
        $roleReturn->data->count = $this->getIfSet("count", $response);

        return $roleReturn->data;
    }

}