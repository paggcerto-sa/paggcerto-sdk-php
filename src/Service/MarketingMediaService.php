<?php
/**
 * Created by PhpStorm.
 * User: marcus.vinicius
 * Date: 27/08/2018
 * Time: 11:19
 */

namespace Paggcerto\Service;


use stdClass;

class MarketingMediaService extends PaggcertoService
{
    const SEARCH_MARKETING_MEDIA = "v2/marketing-medias";

    /**
     * @param array $routeParams
     * @param array $queryString
     * @param string $path
     * @return mixed
     */
    public function getRequest($routeParams = [], $queryString = [], $path = MarketingMediaService::SEARCH_MARKETING_MEDIA)
    {
        return parent::getRequest($routeParams, $queryString, $path);
    }

    /**
     * @return mixed
     */
    protected function initialize()
    {
        $this->data = new stdClass();
        $this->data->marketingMedias = [];
    }

    /**
     * @param stdClass $response
     * @return mixed
     */
    protected function populate(stdClass $response)
    {
        $this->data->marketingMedias = [];
        foreach ($response->marketingMedias as $marketingMedia) {
            $temp = new stdClass();
            $temp->id = $this->getIfSet("id", $marketingMedia);
            $temp->name = $this->getIfSet("name", $marketingMedia);
            array_push($this->data->marketingMedias, $temp);
        }

        return $this->data->marketingMedias;
    }
}