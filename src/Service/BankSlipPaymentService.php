<?php
/**
 * User: erick.antunes
 * Date: 03/09/2018
 * Time: 14:50
 */

namespace Paggcerto\Service;


use Requests;
use stdClass;

class BankSlipPaymentService extends PaggcertoPayApiService
{
    const BANKSLIPS_URL  = self::PAYMENTS_VERSION . "/bank-slips";

    /**
     * @param $discount
     * @return $this
     */
    public function setDiscount($discount)
    {
        $this->data->discount = $discount;

        return $this;
    }

    /**
     * @param $fines
     * @return $this
     */
    public function setFines($fines)
    {
        $this->data->fines = $fines;

        return $this;
    }

    /**
     * @param $interest
     * @return $this
     */
    public function setInterest($interest)
    {
        $this->data->interest = $interest;

        return $this;
    }

    /**
     * @param $discountDays
     * @return $this
     */
    public function setDiscountDays($discountDays)
    {
        $this->data->discountDays = $discountDays;

        return $this;
    }

    /**
     * @param $acceptedUntil
     * @return $this
     */
    public function setAcceptedUntil($acceptedUntil)
    {
        $this->data->acceptedUntil = $acceptedUntil;

        return $this;
    }

    /**
     * @param $instructions
     * @return $this
     */
    public function setInstructions($instructions)
    {
        $this->data->instructions = $instructions;

        return $this;
    }

    /**
     * @param $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->data->number = $number;

        return $this;
    }

    /**
     * @param $dueDate
     * @return $this
     */
    public function setDueDate($dueDate)
    {
        $this->data->duedate = $dueDate;

        return $this;
    }

    public function setNote($note)
    {
        $this->data->note = $note;

        return $this;
    }

    /**
     * @param $dueDate
     * @param $amount
     * @return $this
     */
    public function addInstallment($dueDate, $amount)
    {
        $installment = new Installments($dueDate, $amount);
        array_push($this->createInstallments()->data->installments, $installment);

        return $this;
    }

    /**
     * @param $name
     * @param $taxDocument
     * @param null $sellingKey
     * @return $this
     */
    public function addPayer($name, $taxDocument, $sellingKey = null)
    {
        $payer = new Payer($name, $taxDocument, $sellingKey);
        array_push($this->data->payers, $payer);

        return $this;
    }

    /**
     * @return $this
     */
    public function removePayers()
    {
        $this->data->payers = [];

        return $this;
    }

    /**
     * @return $this
     */
    public function removeDates()
    {
        $this->data->dates = [];

        return $this;
    }

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
     * @param $paymentId
     * @return $this
     */
    public function addPayment($paymentId)
    {
        array_push($this->data->payments, $paymentId);

        return $this;
    }

    /**
     * @param $id
     * @param $paysFee
     * @param $salesCommission
     * @param $amount
     * @return $this
     */
    public function addSplitter($id, $paysFee, $salesCommission, $amount)
    {
        $splitter = new Splitter($id, $paysFee, $salesCommission, $amount);
        array_push($this->createSplitters()->data->splitters, $splitter);

        return $this;
    }

    /**
     * @return mixed|stdClass
     */
    public function pay()
    {
        $urlPath = CardPaymentService::PAYMENTS_URL . "/bank-slips";
        $response = $this->httpRequest($urlPath, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed|stdClass
     */
    public function bankSlipReplace()
    {
        $urlPath = self::BANKSLIPS_URL . "/replace/{$this->data->number}";
        $response = $this->httpRequest($urlPath, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function makeBankSlipPDF()
    {
        $urlPath = self::BANKSLIPS_URL . "/pdf/{$this->data->paymentId}";
        return $this->httpRequest($urlPath, Requests::GET);
    }

    /**
     * @return mixed|stdClass
     */
    public function cancel()
    {
        $urlPath = self::BANKSLIPS_URL . "/cancel/{$this->data->number}";
        $response = $this->httpRequest($urlPath, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function makeMultiplesBankSlipPDF()
    {
        $urlPath = self::BANKSLIPS_URL . "/zip?";

        foreach ($this->data->payments as $key => $payment)
        {
            if($key == 0)
            {
                $urlPath .= "payments={$payment}";
                continue;
            }

            $urlPath .= "&payments={$payment}";
        }

        return $this->httpRequest($urlPath, Requests::GET);
    }

    /**
     * @return mixed|void
     */
    protected function init()
    {
        $this->data = new stdClass();
        $this->data->payers = [];
        $this->data->payments = [];
    }

    /**
     * @param stdClass $response
     * @return mixed|stdClass
     */
    protected function fillEntity(stdClass $response)
    {
        $result = clone $this;
        $result->data = new stdClass();
        $result->data->payments = $this->getIfSet("payments", $response);
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
     * @return $this
     */
    private function createSplitters()
    {
        if(!property_exists($this->data, "splitters"))
            $this->data->splitters = [];

        return $this;
    }

    /**
     * @return $this
     */
    private function createInstallments()
    {
        if(!property_exists($this->data, "installments"))
            $this->data->installments = [];

        return $this;
    }
}

class Payer
{
    /**
     * @var null
     */
    public $sellingKey;
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $taxDocument;

    /**
     * Payer constructor.
     * @param $name
     * @param $taxDocument
     * @param null $sellingKey
     */
    public function __construct($name, $taxDocument, $sellingKey = null)
    {
        $this->sellingKey = $sellingKey;
        $this->name = $name;
        $this->taxDocument = $taxDocument;
    }
}

class Installments
{
    /**
     * @var
     */
    public $dueDate;
    /**
     * @var
     */
    public $amount;

    /**
     * Installments constructor.
     * @param $dueDate
     * @param $amount
     */
    public function __construct($dueDate, $amount)
    {
        $this->dueDate = $dueDate;
        $this->amount = $amount;
    }
}