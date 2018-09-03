<?php
/**
 * User: erick.antunes
 * Date: 31/08/2018
 * Time: 11:59
 */

namespace Paggcerto\Service;


use Paggcerto\Paggcerto;
use stdClass;

class PaggcertoAccountApiService extends PaggcertoService
{

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
        // TODO: Implement fillEntity() method.
    }

    protected function setUpEndpoint()
    {
        $endpointEnvironment = $this->paggcerto->getEndpointEnvironment();

        if($endpointEnvironment == Paggcerto::ENDPOINT_SANDBOX)
            $this->paggcerto->setEndpoint(Paggcerto::ACCOUNT_ENDPOINT_SANDBOX);

        if($endpointEnvironment == Paggcerto::ENDPOINT_PROD)
            $this->paggcerto->setEndpoint(Paggcerto::ACCOUNT_ENDPOINT_PROD);

        $this->paggcerto->createNewSession();
    }
}