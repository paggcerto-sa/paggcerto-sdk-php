<?php
/**
 * User: erick.antunes
 * Date: 30/08/2018
 * Time: 12:34
 */

namespace Paggcerto\Service;


use Requests;
use stdClass;

class CardPaymentService extends PaggcertoPayApiService
{
    const BINS_URL = self::PAYMENTS_VERSION . "/bins";
    const PAYMENTS_URL = self::PAYMENTS_VERSION . "/pay";
    const PAYMENTS_CARD_TRANSACTION_URL = self::PAYMENTS_VERSION . "/card-transactions";
    const PAYMENTS_CAPTURE_URL = self::PAYMENTS_VERSION . "/pay/cards/capture";

    /**
     * @param $sellingKey
     * @return $this
     */
    public function setSellingKey($sellingKey)
    {
        $this->data->sellingKey = $sellingKey;

        return $this;
    }

    /**
     * @param $holderName
     * @param $number
     * @param $expirationMonth
     * @param $expirationYear
     * @param $amountPaid
     * @param $securityCode
     * @param $installments
     * @param $credit
     * @return $this
     */
    public function addCard($holderName, $number, $expirationMonth,
                            $expirationYear, $amountPaid, $securityCode, $installments, $credit)
    {
        $card = new Card($holderName, $number, $expirationMonth,
            $expirationYear, $amountPaid, $securityCode, $installments, $credit);
        array_push($this->data->cards, $card);

        return $this;
    }

    /**
     * @param $id
     * @param $amount
     * @param $installments
     * @param $credit
     * @return $this
     */
    public function addCardWithId($id, $amount, $installments = 1, $credit = true) {
        $card = new Card(null,null,null,null,$amount,null, $installments, $credit, $id);
        array_push($this->data->cards, $card);

        return $this;
    }


    /**
     * @param $id
     * @param $paysFee
     * @param $salesCommission
     * @param $amount
     * @return $this
     */
    public function addSplitters($id, $paysFee, $salesCommission, $amount)
    {
		if (!isset($this->data->splitters) || $this->data->splitters == null) {
			$this->data->splitters = [];
		}

        $splitter = new Splitter($id, $paysFee, $salesCommission, $amount);
        array_push($this->data->splitters, $splitter);

        return $this;
    }

    /**
     * @return $this
     */
    public function removeAllCards()
    {
        $this->data->cards = [];

        return $this;
    }

    /**
     * @return $this
     */
    public function removeAllSplitters()
    {
        $this->data->splitters = [];

        return $this;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->data->amount = $amount;

        return $this;
    }

    /**
     * @param $serialNumber
     * @return $this
     */
    public function setPaymentDeviceSerialNumber($serialNumber)
    {

        $this->createPaymentDevice()->data->paymentDevice->serialNumber = $serialNumber;

        return $this;
    }

    /**
     * @param $deviceModel
     * @return $this
     */
    public function setPaymentDeviceModel($deviceModel)
    {
        $this->createPaymentDevice()->data->paymentDevice->model = $deviceModel;

        return $this;
    }

    /**
     * @return $this
     */
    public function isAuthorizedSale()
    {
        $this->data->cards[0]->authorization = true;

        return $this;
    }

    /**
     * @param $days
     * @return $this
     */
    public function setDaysLimitAuthorization($days)
    {
        $this->data->cards[0]->daysLimitAuthorization = $days;

        return $this;
    }

    /**
     * @param $appVersion
     * @return $this
     */
    public function setMobileDeviceAppVersion($appVersion)
    {
        $this->createMobileDevice()->data->mobileDevice->appVersion = $appVersion;

        return $this;
    }

    /**
     * @param $manufacturer
     * @return $this
     */
    public function setMobileDeviceManufacturer($manufacturer)
    {
        $this->createMobileDevice()->data->mobileDevice->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * @param $mobileModel
     * @return $this
     */
    public function setMobileDeviceModel($mobileModel)
    {
        $this->createMobileDevice()->data->mobileDevice->model = $mobileModel;

        return $this;
    }

    /**
     * @param $latitude
     * @return $this
     */
    public function setGeoLocationLatitude($latitude)
    {
        $this->createGeolocation()->data->geolocation->latitude = $latitude;

        return $this;
    }

    /**
     * @param $longitude
     * @return $this
     */
    public function setGeoLocationLongitude($longitude)
    {
        $this->createGeolocation()->data->geolocation->longitude = $longitude;

        return $this;
    }

    /**
     * @param $installments
     * @return $this
     */
    public function setInstallments($installments)
    {
        $this->data->installments = $installments;

        return $this;
    }

    /**
     * @param $cardBrand
     * @return $this
     */
    public function setCardBrand($cardBrand)
    {
        $this->data->cardBrand = $cardBrand;

        return $this;
    }

    /**
     * @param $isCredit
     * @return $this
     */
    public function setCredit($isCredit)
    {
        $this->data->credit = $isCredit;

        return $this;
    }

    /**
     * @param $isPinpad
     * @return $this
     */
    public function setPinpad($isPinpad)
    {
        $this->data->pinpad = $isPinpad;

        return $this;
    }

    /**
     * @param $nsu
     * @return $this
     */
    public function setNsu($nsu)
    {
        $this->data->nsu = $nsu;

        return $this;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->data->email = $email;

        return $this;
    }

    /**
     * @param $mobile
     * @return $this
     */
    public function setMobile($mobile)
    {
        $this->data->mobile = $mobile;

        return $this;
    }

    /**
     * @param $isCustomerPaysFee
     * @return $this
     */
    public function setCustomerPaysFee($isCustomerPaysFee)
    {
        $this->data->customerPaysFee = $isCustomerPaysFee;

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
     * @return mixed
     */
    public function getCardsBrands()
    {
        $response = $this->getRequest([], [], self::BINS_URL);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function cardTransactionCancel()
    {
        $urlPath = self::PAYMENTS_CARD_TRANSACTION_URL . "/cancel/{$this->data->nsu}";
        $response = $this->httpRequest($urlPath, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function paySimulate()
    {
        $urlPath = self::PAYMENTS_URL . "/simulate";
        $response = $this->httpRequest($urlPath, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function pay()
    {
        $urlPath = self::PAYMENTS_URL . "/cards";
        $response = $this->httpRequest($urlPath, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     *
     */
    public function payContinue()
    {
        $urlPath = self::PAYMENTS_URL . "/cards/{$this->data->paymentId}";
        $response = $this->httpRequest($urlPath, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    public function sendReceipt()
    {
        $urlPath = self::PAYMENTS_CARD_TRANSACTION_URL . "/send-receipt/{$this->data->nsu}";
        $this->httpRequest($urlPath, Requests::POST, $this->data);
    }

    /**
     * @return mixed
     */
    public function paymentCapture()
    {
        $urlPath = self::PAYMENTS_CAPTURE_URL . "/{$this->data->paymentId}";
        $response = $this->httpRequest($urlPath, Requests::PUT, $this->data);

        return $this->fillEntity($response);
    }

    /**
     * @return mixed
     */
    protected function init()
    {
        $this->data = new stdClass();
        $this->data->cards = [];
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
        $result->data->amountCharged = $this->getIfSet("amountCharged", $response);
        $result->data->amountReceived = $this->getIfSet("amountReceived", $response);
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
        $result->data->splitters = $this->getIfSet("splitters", $response);
        $result->data->bankSlips = $this->getIfSet("bankSlips", $response);

        return $result->data;
    }

    /**
     * @return $this
     */
    private function createGeolocation()
    {
        if(!property_exists($this->data, "geolocation"))
            $this->data->geolocation = new stdClass();

        return $this;
    }

    /**
     * @return $this
     */
    private function createPaymentDevice()
    {
        if(!property_exists($this->data, "paymentDevice"))
            $this->data->paymentDevice = new stdClass();

        return $this;
    }

    /**
     * @return $this
     */
    private function createMobileDevice()
    {
        if(!property_exists($this->data, "mobileDevice"))
            $this->data->mobileDevice = new stdClass();

        return $this;
    }
}

class Card
{
    /**
     * @var
     */
    public $holderName;
    /**
     * @var
     */
    public $number;
    /**
     * @var
     */
    public $experiationMonth;
    /**
     * @var
     */
    public $expirationYear;
    /**
     * @var
     */
    public $amountPaid;
    /**
     * @var int
     */
    public $installments;
    /**
     * @var bool
     */
    public $credit;
    /**
     * @var
     */
    public $securityCode;
    /**
     * @var
     */
    public $id;

    /**
     * Card constructor.
     * @param $holderName
     * @param $number
     * @param $expirationMonth
     * @param $expirationYear
     * @param $amountPaid
     * @param $securityCode
     * @param int $installments
     * @param bool $credit
     * @param $id
     */
    public function __construct($holderName = null, $number = null, $expirationMonth = null,
                                $expirationYear = null, $amountPaid = null, $securityCode = null, $installments = 1, $credit = true , $id = null)
    {
        $this->id = $id;
        $this->holderName = $holderName;
        $this->number = $number;
        $this->expirationMonth = $expirationMonth;
        $this->expirationYear = $expirationYear;
        $this->amountPaid = $amountPaid;
        $this->installments = $installments;
        $this->credit = $credit;
        $this->securityCode = $securityCode;
    }
}

class Splitter
{
    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $paysFee;
    /**
     * @var
     */
    public $salesCommission;
    /**
     * @var
     */
    public $amount;

    /**
     * Splitter constructor.
     * @param $id
     * @param $paysFee
     * @param $salesCommission
     * @param $amount
     */
    public function __construct($id, $paysFee, $salesCommission, $amount)
    {
        $this->id = $id;
        $this->paysFee = $paysFee;
        $this->salesCommission = $salesCommission;
        $this->amount = $amount;
    }
}