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
        $this->data->cities = new stdClass();
    }

    protected function populate(stdClass $response)
    {
        $city = clone $this;
        $this->data->cities = new stdClass();
        $city = $this->getIfSet("cities", $response);
        return $city;
    }
}