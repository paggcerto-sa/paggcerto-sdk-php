<?php
/**
 * User: erick.antunes
 * Date: 03/10/2018
 * Time: 14:52
 */

namespace Paggcerto\Service;

use Requests;
use stdClass;

class CardManagementService extends PaggcertoPayApiService
{
    const CARDS_URL = self::PAYMENTS_VERSION . "/cards";

    public function setHolderName($holderName)
    {
        $this->data->holderName = $holderName;

        return $this;
    }

    public function setNumber($number)
    {
        $this->data->number = $number;

        return $this;
    }

    public function setExpirationMonth($expirationMonth)
    {
        $this->data->expirationMonth = $expirationMonth;

        return $this;
    }

    public function setExpirationYear($expirationYear)
    {
        $this->data->expirationYear = $expirationYear;

        return $this;
    }

    public function setSecurityCode($securityCode)
    {
        $this->data->securityCode = $securityCode;

        return $this;
    }

    public function setBrands($brands)
    {
        $this->data->brands = $brands;

        return $this;
    }

    public function setFinals($finals)
    {
        $this->data->finals = $finals;

        return $this;
    }

    public function setCardId($cardId)
    {
        $this->data->cardId = $cardId;

        return $this;
    }

    public function cardRegister()
    {
        $response = $this->httpRequest(self::CARDS_URL, Requests::POST, $this->data);

        return $this->fillEntity($response);
    }

    public function cardList()
    {
        $this->queryString = $this->data->brands;
        $this->mountUrlArray("brands");
        $this->queryString = $this->data->finals;
        $this->mountUrlArray("finals");

        $response = $this->httpRequest(self::CARDS_URL . "$this->path", Requests::GET);

        return $this->fillEntity($response);
    }

    public function cardFind()
    {
        $response = $this->httpRequest(self::CARDS_URL . "/{$this->data->cardId}", Requests::GET);

        return $this->fillEntity($response);
    }

    public function cardDelete()
    {
        $response = $this->httpRequest(self::CARDS_URL . "/{$this->data->cardId}", Requests::DELETE);

        return $this->fillEntity($response);
    }

    protected function fillEntity(stdClass $response)
    {
        $result = clone $this;
        $result->data = new stdClass();

        $listKeys = ["id", "holderName", "number", "brand", "expirationMonth", "expirationYear", "cards", "count"];
        $this->hydratorObject($result->data,$listKeys,$response);

        return $result->data;
    }
}