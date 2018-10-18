<?php
/**
 * User: erick.antunes
 * Date: 18/10/2018
 * Time: 10:23
 */

namespace Paggcerto\Service;

use Requests;
use stdClass;

class WebhooksService extends PaggcertoWebhookApiService
{
    const CALLBACKS_URL = self::WEBHOOKS_VERSION . "/callbacks";

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->data->url = $url;

        return $this;
    }

    /**
     * @param $events
     * @return $this
     */
    public function setEvents($events)
    {
        $this->data->events = $events;

        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->data->id = $id;

        return $this;
    }

    /**
     * @param $urls
     * @return $this
     */
    public function setUrls($urls)
    {
        $this->data->urls = $urls;

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
     * @return mixed
     */
    public function create()
    {
        $response = $this->httpRequest(self::CALLBACKS_URL, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @param stdClass $response
     * @return mixed
     */
    protected function fillEntity(stdClass $response)
    {
        $result = clone $this;
        $result->data = new stdClass();
        $result->data->id = $this->getIfSet("id", $response);
        $result->data->url = $this->getIfSet("url", $response);
        $result->data->events = $this->getIfSet("events", $response);
        $result->data->links = $this->getIfSet("links", $response);
        $result->data->webHooks = $this->getIfSet("webHooks", $response);
        $result->data->count = $this->getIfSet("count", $response);

        return $result->data;
    }

    /**
     * @return mixed
     */
    public function update()
    {
        $urlPath = self::CALLBACKS_URL . "/{$this->data->id}";

        $response = $this->httpRequest($urlPath, Requests::PUT, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function wehooksList()
    {
        $this->queryString = $this->data->events;
        $this->mountUrlArray("events");
        $this->queryString = $this->data->urls;
        $this->mountUrlArray("urls");

        $response = $this->httpRequest(self::CALLBACKS_URL . "{$this->path}&index={$this->data->index}&length={$this->data->length}", Requests::GET);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function find()
    {
        $urlPath = self::CALLBACKS_URL . "/{$this->data->id}";

        $response = $this->httpRequest($urlPath, Requests::GET);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function delete()
    {
        $urlPath = self::CALLBACKS_URL . "/{$this->data->id}";

        $response = $this->httpRequest($urlPath, Requests::DELETE);

        return $this->fillEntity($response);
    }
}