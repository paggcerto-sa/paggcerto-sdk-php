<?php
/**
 * User: erick.antunes
 * Date: 04/09/2018
 * Time: 15:00
 */

namespace Paggcerto\Service;


use Requests;
use stdClass;

class PaymentService extends PaggcertoPayApiService
{
    const PAYMENTS_CONCLUSION_URL = self::PAYMENTS_VERSION . "/finalize";
    const PAYMENT_CANCEL_URL = self::PAYMENTS_VERSION . "/cancel";

    /**
     * @param $paymentId
     * @return $this
     */
    public function setPaymentId($paymentId)
    {
        $this->data->paymentId = $paymentId;

        return $this;
    }

    public function setNote($note)
    {
        $this->data->note = $note;

        return $this;
    }

    /**
     * @param $addInformation
     * @return $this
     */
    public function setAdditionalInformation($addInformation)
    {
        $this->data->additionalInformation = $addInformation;

        return $this;
    }

    /**
     * @return mixed
     */
    public function paymentCancel()
    {
        $urlPath = self::PAYMENT_CANCEL_URL . "/{$this->data->paymentId}";
        $response = $this->httpRequest($urlPath, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function payFinalize()
    {
        $urlPath = self::PAYMENTS_CONCLUSION_URL . "/{$this->data->paymentId}";
        $response = $this->httpRequest($urlPath, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed|void
     */
    protected function init()
    {
        $this->data = new stdClass();
    }

    /**
     * @param stdClass $response
     * @return mixed
     *
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
}