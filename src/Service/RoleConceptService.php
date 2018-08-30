<?php
/**
 * User: erick.antunes
 * Date: 30/08/2018
 * Time: 09:01
 */

namespace Paggcerto\Service;


use Requests;
use stdClass;

class RoleConceptService extends PaggcertoService
{
    const ROLE_CONCEPTS = RoleService::ROLE_URI;

    public function roleGrantPermission()
    {
        $urlPath = self::ROLE_CONCEPTS . "/{$this->data->roleId}/scopes/grant";
        $this->httpRequest($urlPath, Requests::POST, $this->data);
    }

    public function roleRevokePermission()
    {
        $urlPath = self::ROLE_CONCEPTS . "/{$this->data->roleId}/scopes/revoke";
        $this->httpRequest($urlPath, Requests::POST, $this->data);
    }

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
     * @param $scopes
     * @return $this
     */
    public function setScopes($scopes)
    {
        $this->data->scopes = $scopes;

        return $this;
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
     * @codeCoverageIgnore
     */
    protected function fillEntity(stdClass $response)
    {
        $roleReturn = clone $this;
        $roleReturn-> data = new stdClass();
        $roleReturn->data->scopes = $this->getIfSet("scopes", $response);

        return $roleReturn->data;
    }
}