<?php
/**
 * User: erick.antunes
 * Date: 18/10/2018
 * Time: 10:24
 */

namespace Paggcerto\Service;


use Paggcerto\Paggcerto;
use stdClass;

class PaggcertoWebhookApiService extends PaggcertoService
{

    /**
     * @return mixed
     */
    public function __construct(Paggcerto $paggcerto)
    {
        parent::__construct($paggcerto);
        $this->setUpEndpoint();
    }

    /**
     * @return mixed
     */
    protected function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * @param stdClass $response
     * @return mixed
     */
    protected function fillEntity(stdClass $response)
    {
    }

    protected function setUpEndpoint()
    {
        $endpointEnvironment = $this->paggcerto->getEndpointEnvironment();

        if($endpointEnvironment == Paggcerto::ENDPOINT_SANDBOX)
            $this->paggcerto->setEndpoint(Paggcerto::WEBHOOKS_ENDPOINT_SANDBOX);

        if($endpointEnvironment == Paggcerto::ENDPOINT_PROD)
            $this->paggcerto->setEndpoint(Paggcerto::WEBHOOKS_ENDPOINT_PROD);

        $this->paggcerto->createNewSession();
    }
}