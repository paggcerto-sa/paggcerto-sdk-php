<?php
/**
 * User: erick.antunes
 * Date: 28/08/2018
 * Time: 17:50
 */

namespace Paggcerto\Service;


use Exception;
use Requests;
use stdClass;

class RoleService extends PaggcertoService
{
    const ROLE_URI = self::ACCOUNT_VERSION . "/roles";

    /**
     * @param $roleId
     * @return $this
     */
    public function setRoleId($roleId)
    {
        $this->data->roleId = $roleId;

        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->data->name = $name;

        return $this;
    }

    /**
     * @param $index
     * @return $this
     */
    public function setIndex($index)
    {
        $this->data->index = $index;

        return $this;
    }

    /**
     * @param $length
     * @return $this
     */
    public function setLength($length)
    {
        $this->data->length = $length;

        return $this;
    }

    /**
     * @param $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->data->active = $active;

        return $this;
    }

    /**
     * @return mixed
     */
    public function createRole()
    {
        $response = $this->httpRequest(self::ROLE_URI, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function updateRole()
    {
        $urlPath = self::ROLE_URI . "/{$this->validate()->data->roleId}";
        $response = $this->httpRequest($urlPath, Requests::PUT, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function rolesList()
    {
        if($this->getName())
            $this->queryString["name"] = $this->getName();

        if($this->getIndex())
            $this->queryString["index"] = $this->getIndex();

        if($this->getLength())
            $this->queryString["length"] = $this->getLength();

        $this->path = self::ROLE_URI;

        $response = $this->httpRequest($this->mountUrl(), Requests::GET);

        return $this->fillEntity($response);
    }

    private function getName()
    {
        return $this->getIfSet("name", $this->data);
    }

    private function getIndex()
    {
        return $this->getIfSet("index", $this->data);
    }

    private function getLength()
    {
        return $this->getIfSet("length", $this->data);
    }

    /**
     * @return mixed
     */
    public function searchRole()
    {
        $urlPath = self::ROLE_URI . "/{$this->validate()->data->roleId}";
        $response = $this->httpRequest($urlPath, Requests::GET);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function deactivateRole()
    {
        $urlPath = self::ROLE_URI . "/{$this->validate()->data->roleId}/deactivate";
        $response = $this->httpRequest($urlPath, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function activateRole()
    {
        $urlPath = self::ROLE_URI . "/{$this->validate()->data->roleId}/activate";
        $response = $this->httpRequest($urlPath, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function deleteRole()
    {
        $urlPath = self::ROLE_URI . "/{$this->validate()->data->roleId}";
        $response = $this->httpRequest($urlPath, Requests::DELETE);

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
        $roleReturn->data = new stdClass();
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

    /**
     * @return $this
     * @throws Exception
     */
    private function validate()
    {
        if (!property_exists($this->data, "roleId"))
            throw new Exception("roleId needed be fill");

        return $this;
    }
}