<?php
/**
 * User: erick.antunes
 * Date: 25/07/2018
 * Time: 15:28
 */

namespace Paggcerto\Service;


use stdClass;

class CityService extends PaggcertoService
{

    const SEARCH_CITIES = "v2/cities/%s";

    protected function initialize()
    {
        $this->data = new stdClass();
        $this->data->cities = [];
    }

    protected function populate(stdClass $response)
    {
        $city = clone $this;
        $this->data->cities = [];
        foreach ($response->cities as $city) {
            $temp = new stdClass();
            $temp->code = $this->getIfSet("code", $city);
            $temp->name = $this->getIfSet("name", $city);
            $temp->state = $this->getIfSet("state", $city);
            array_push($this->data->cities, $temp);
        }

        return $this->data->cities;
    }
}