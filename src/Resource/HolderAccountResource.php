<?php
/**
 * User: erick.antunes
 * Date: 24/07/2018
 * Time: 15:51
 */

namespace Paggcerto\Resource;

use stdClass;

class HolderAccountResource extends PaggcertoResource
{

    public function setHolderFullName($fullname)
    {
        $this->data->holder->fullName = $fullname;

        return $this;
    }

    public function setBirthDate($birthDate)
    {
        $this->data->hoder->birthDate = $birthDate;

        return $this;
    }

    public function setGender($gender)
    {
        $this->data->holder->gender = $gender;

        return $this;
    }

    public function setTaxDocument($taxDocument)
    {
        $this->data->holder->taxDocument = $taxDocument;

        return $this;
    }

    public function setPhone($phone)
    {
        $this->data->holder->phone = $phone;

        return $this;
    }

    public function setMobile($mobileNumber)
    {
        $this->data->holder->mobile = $mobileNumber;

        return $this;
    }

    public function setTradeName($tradeName)
    {
        $this->data->holder->company->tradeName = $tradeName;

        return $this;
    }

    public function setCompanyFullName($companyFullName)
    {
        $this->data->holder->company->fullName = $companyFullName;

        return $this;
    }

    public function setCompanyTaxDocument($companyTaxDocument)
    {
        $this->data->holder->company->taxDocument = $companyTaxDocument;

        return $this;
    }

    public function setBusinessTypeId($businessTypeId)
    {
        $this->data->holder->company->businessTypeId = $businessTypeId;

        return $this;
    }

    public function setAddressCityCode($addCityCode)
    {
        $this->data->address->cityCode = $addCityCode;

        return $this;
    }

    public function setAddressDistrict($addDistrict)
    {
        $this->data->address->district = $addDistrict;

        return $this;
    }

    public function setAddressLine1($addLine1)
    {
        $this->data->address->line1 = $addLine1;

        return $this;
    }

    public function setAddressLine2($addLine2)
    {
        $this->data->address->line2 = $addLine2;

        return $this;
    }

    public function setStreetNumber($addStreetNumber)
    {
        $this->data->address->streetNumber = $addStreetNumber;

        return $this;
    }

    public function setZipCode($addZipCode)
    {
        $this->data->address->zipCode = $addZipCode;

        return $this;
    }

    public function setBankNumber($bankNumber)
    {
        $this->data->bankAccount->bankNumber = $bankNumber;

        return $this;
    }

    public function setBankAccountNumber($bankAccountNumber)
    {
        $this->data->bankAccount->accountNumber = $bankAccountNumber;

        return $this;
    }

    public function createHolderAccount()
    {

    }

    protected function initialize()
    {
        $this->data = new stdClass();
        $this->data->holder = new stdClass();
        $this->data->address = new stdClass();
        $this->data->bankAccount = new stdClass();
        $this->data->user = new stdClass();
        $this->data->holder->company = new stdClass();
    }

    protected function populate(stdClass $response)
    {
        $holderAccount = clone $this;
        $holderAccount->data->holder = new stdClass();
    }
}