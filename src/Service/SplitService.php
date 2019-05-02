<?php
/**
 * Created by PhpStorm.
 * User: marcus.vinicius
 * Date: 02/05/2019
 * Time: 11:30
 */

namespace Paggcerto\Service;


use Exception;
use Requests;
use stdClass;

class SplitService extends PaggcertoPayApiService
{
	const SPLIT_URI = self::PAYMENTS_VERSION . "/splitters";

	/**
	 * @param $name
	 * @return $this
	 */
	public function setName($name)
	{
		$this->data->name = $name;

		return $this;
	}

	/**
	 * @param $transferDays
	 * @return $this
	 */
	public function setTransferDays($transferDays)
	{
		$this->data->transferDays = $transferDays;

		return $this;
	}

	/**
	 * @param $anticipatedTransfer
	 * @return $this
	 */
	public function setAnticipatedTransfer($anticipatedTransfer)
	{
		$this->data->anticipatedTransfer = $anticipatedTransfer;

		return $this;
	}

	/**
	 * @param $addCityCode
	 * @return $this
	 */
	public function setAddressCityCode($addCityCode)
	{
		$this->data->address->cityCode = $addCityCode;

		return $this;
	}

	/**
	 * @param $addDistrict
	 * @return $this
	 */
	public function setAddressDistrict($addDistrict)
	{
		$this->data->address->district = $addDistrict;

		return $this;
	}

	/**
	 * @param $addLine1
	 * @return $this
	 */
	public function setAddressLine1($addLine1)
	{
		$this->data->address->line1 = $addLine1;

		return $this;
	}

	/**
	 * @param $addLine2
	 * @return $this
	 */
	public function setAddressLine2($addLine2)
	{
		$this->data->address->line2 = $addLine2;

		return $this;
	}

	/**
	 * @param $addStreetNumber
	 * @return $this
	 */
	public function setAddressStreetNumber($addStreetNumber)
	{
		$this->data->address->streetNumber = $addStreetNumber;

		return $this;
	}

	/**
	 * @param $addZipCode
	 * @return $this
	 */
	public function setAddressZipCode($addZipCode)
	{
		$this->data->address->zipCode = $addZipCode;

		return $this;
	}

	/**
	 * @param $bankNumber
	 * @return $this
	 */
	public function setBankAccountBankNumber($bankNumber)
	{
		$this->data->bankAccount->bankNumber = $bankNumber;

		return $this;
	}

	/**
	 * @param $bankAccountNumber
	 * @return $this
	 */
	public function setBankAccountNumber($bankAccountNumber)
	{
		$this->data->bankAccount->accountNumber = $bankAccountNumber;

		return $this;
	}

	/**
	 * @param $bankBranchNumber
	 * @return $this
	 */
	public function setBankAccountBranchNumber($bankBranchNumber)
	{
		$this->data->bankAccount->bankBranchNumber = $bankBranchNumber;

		return $this;
	}

	/**
	 * @param $bankVariation
	 * @return $this
	 */
	public function setBankAccountVariation($bankVariation)
	{
		$this->data->bankAccount->variation = $bankVariation;

		return $this;
	}

	/**
	 * @param $bankType
	 * @return $this
	 */
	public function setBankAccountType($bankType)
	{
		$this->data->bankAccount->type = $bankType;

		return $this;
	}

	/**
	 * @param $holderName
	 * @return $this
	 */
	public function setHolderName($holderName)
	{
		$this->data->bankAccount->holderName = $holderName;

		return $this;
	}

	/**
	 * @param $taxDocument
	 * @return $this
	 */
	public function setTaxDocument($taxDocument)
	{
		$this->data->bankAccount->taxDocument = $taxDocument;

		return $this;
	}

	/**
	 * @param $splitterId
	 * @return $this
	 */
	public function setSplitterId($splitterId)
	{
		$this->data->id = $splitterId;

		return $this;
	}

	/**
	 * @return mixed
	 */
	protected function init()
	{
		$this->data = new stdClass();
		$this->data->address = new stdClass();
		$this->data->bankAccount = new stdClass();
	}

	/**
	 * @param stdClass $response
	 * @return mixed
	 */
	protected function fillEntity(stdClass $response)
	{
		$splitReturn = clone $this;
		$splitReturn->data = new stdClass();
		$splitReturn->data->id = $this->getIfSet("id", $response);
		$splitReturn->data->name = $this->getIfSet("name", $response);
		$splitReturn->data->transferDays = $this->getIfSet("transferDays", $response);
		$splitReturn->data->anticipatedTransfer = $this->getIfSet("anticipatedTransfer", $response);
		$splitReturn->data->address = $this->getIfSet("address", $response);
		$splitReturn->data->bankAccount = $this->getIfSet("bankAccount", $response);

		return $splitReturn->data;
	}

	/**
	 * @return mixed
	 */
	public function createSplitter()
	{
		$response = $this->httpRequest(self::SPLIT_URI, Requests::POST, $this->data);

		return $this->fillEntity($response);
	}

	/**
	 * @return mixed
	 * @throws Exception
	 */
	public function updateSplitter()
	{
		$urlPath = self::SPLIT_URI . "/{$this->validate()->data->id}";
		$response = $this->httpRequest($urlPath, Requests::PUT, $this->data);

		return $this->fillEntity($response);
	}

	/**
	 * @return mixed
	 * @throws Exception
	 */
	public function searchSplitter()
	{
		$urlPath = self::SPLIT_URI . "/find/{$this->validate()->data->id}";
		$response = $this->httpRequest($urlPath, Requests::GET);

		return $this->fillEntity($response);
	}

	/**
	 * @return mixed
	 */
	public function splittersList()
	{
		if($this->getName())
			$this->queryString["name"] = $this->getName();

		if($this->getIndex())
			$this->queryString["index"] = $this->getIndex();

		if($this->getLength())
			$this->queryString["length"] = $this->getLength();

		$response = $this->getRequest([],$this->queryString, self::SPLIT_URI);

		return $this->fillEntity($response);
	}

	private function getName()
	{
		return $this->getIfSet("name", $this->data);
	}

	private function getIndex()
	{
		return $this->getIfSet("index", $this->data);
	}

	private function getLength()
	{
		return $this->getIfSet("length", $this->data);
	}
	/**
	 * @return $this
	 * @throws Exception
	 */
	private function validate()
	{
		if (!property_exists($this->data, "id"))
			throw new Exception("id needed be fill");

		return $this;
	}
}