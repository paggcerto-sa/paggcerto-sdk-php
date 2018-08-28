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

    const SEARCH_CITIES = "v2/cities";

    /**
     * @param array $routeParams
     * @param array $queryString
     * @param string $path
     * @return mixed
     */
    public function getRequest($routeParams = [], $queryString = [], $path = CityService::SEARCH_CITIES)
    {
        return parent::getRequest($routeParams, $queryString, $path);
    }

    /**
     * @return mixed|void
     */
    protected function init()
    {
        $this->data = new stdClass();
        $this->data->cities = [];
    }

    /**
     * @param stdClass $response
     * @return mixed
     */
    protected function fillEntity(stdClass $response)
    {
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