<?php
/**
 * User: erick.antunes
 * Date: 28/08/2018
 * Time: 17:50
 */

namespace Paggcerto\Service;


use stdClass;

class RoleService extends PaggcertoService
{

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
        $return = clone $this;
        $return-> data = new stdClass();
    }
}