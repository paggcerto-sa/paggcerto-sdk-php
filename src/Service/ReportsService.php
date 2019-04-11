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

        $listKeys = [
            "id", "sellingKey", "status", "createdAt", "canceledAt", "completedAt", "amount", "amountPaid",
            "cancelable", "additionalInformation", "cardTransactions", "bankSlips", "splitters"
        ];
        $this->hydratorObject($result->data,$listKeys,$response);

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