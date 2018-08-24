<?php
/**
 * Created by PhpStorm.
 * User: marcus.vinicius
 * Date: 24/08/2018
 * Time: 17:48
 */

namespace Paggcerto\Service;

use stdClass;

class BusinessTypeService extends PaggcertoService
{
    const SEARCH_BUSINESS_TYPES = "v2/business-types";

    protected function initialize()
    {
        $this->data = new stdClass();
        $this->data->businessTypes = [];
    }

    protected function populate(stdClass $response)
    {
        $this->data->businessTypes = [];
        foreach ($response->businessTypes as $bussinesType) {
            $temp = new stdClass();
            $temp->code = $this->getIfSet("id", $bussinesType);
            $temp->name = $this->getIfSet("name", $bussinesType);
            $temp->state = $this->getIfSet("acronym", $bussinesType);
            array_push($this->data->businessTypes, $temp);
        }

        return $this->data->businessTypes;
    }
}