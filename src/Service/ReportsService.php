<?php
/**
 * User: erick.antunes
 * Date: 13/03/2019
 * Time: 11:44
 */

namespace Paggcerto\Service;

use Requests;
use stdClass;

class ReportsService extends PaggcertoPayApiService
{
    const PAYMENTS_DETAILS_URL = self::PAYMENTS_VERSION . "/find";

    /**
     * @param $paymentId
     * @return $this
     */
    public function setPaymentId($paymentId)
    {
        $this->data->paymentId = $paymentId;

        return $this;
    }

    /**
     * @return mixed|stdClass
     */
    public function getPaymentDetails()
    {
        $urlPath = self::PAYMENTS_DETAILS_URL . "/{$this->data->paymentId}";
        $response = $this->httpRequest($urlPath, Requests::GET);

        return $this->fillEntity($response);
    }

    /**
     * @param stdClass $response
     * @return mixed|stdClass
     */
    protected function fillEntity(stdClass $response)
    {
        $result = clone $this;
        $result->data = new stdClass();
        $result->data->id = $this->getIfSet("id", $response);
        $result->data->sellingKey = $this->getIfSet("sellingKey", $response);
        $result->data->status = $this->getIfSet("status", $response);
        $result->data->createdAt = $this->getIfSet("createdAt", $response);
        $result->data->canceledAt = $this->getIfSet("canceledAt", $response);
        $result->data->completedAt = $this->getIfSet("completedAt", $response);
        $result->data->amount = $this->getIfSet("amount", $response);
        $result->data->amountPaid = $this->getIfSet("amountPaid", $response);
        $result->data->cancelable = $this->getIfSet("cancelable", $response);
        $result->data->additionalInformation = $this->getIfSet("additionalInformation", $response);
        $result->data->cardTransactions = $this->getIfSet("cardTransactions", $response);
        $result->data->bankSlips = $this->getIfSet("bankSlips", $response);
        $result->data->splitters = $this->getIfSet("splitters", $response);

        return $result->data;
    }

    /**
     * @return mixed|void
     */
    protected function init()
    {
        $this->data = new stdClass();
    }
}