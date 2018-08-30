<?php
/**
 * User: erick.antunes
 * Date: 30/08/2018
 * Time: 12:34
 */

namespace Paggcerto\Service;


use stdClass;

class CardPaymentService extends PaggcertoService
{
    const BINS_URL = self::PAYMENTS_VERSION . "/bins";
    const PAYMENTS_URL = self::PAYMENTS_VERSION . "/pay";

    public function getCardsBrands()
    {
        $response = $this->getRequest([], [], self::BINS_URL);

        return $this->fillEntity($response);
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
     */
    protected function fillEntity(stdClass $response)
    {
        $result = clone $this;
        $result->data = new stdClass();
        $result->data->bins = $this->getIfSet("bins", $response);
        $result->data->count = $this->getIfSet("count", $response);

        return $result->data;
    }
}