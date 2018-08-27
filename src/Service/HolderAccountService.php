<?php
/**
 * User: erick.antunes
 * Date: 24/07/2018
 * Time: 15:51
 */

namespace Paggcerto\Service;

use stdClass;

class HolderAccountService extends PaggcertoService
{
    const SIGNUP_SELLER = "%s/signup/seller";

    /**
     * @return mixed
     */
    public function getHolderFullName()
    {
        return $this->data->holder->fullName;
    }

    /**
     * @param $fullname
     * @return $this
     */
    public function setHolderFullName($fullname)
    {
        $this->data->holder->fullName = $fullname;

        return $this;
    }

    /**
     * @param $birthDate
     * @return $this
     */
    public function setBirthDate($birthDate)
    {
        $this->data->holder->birthDate = $birthDate;

        return $this;
    }

    /**
     * @param $gender
     * @return $this
     */
    public function setGender($gender)
    {
        $this->data->holder->gender = $gender;

        return $this;
    }

    /**
     * @param $taxDocument
     * @return $this
     */
    public function setTaxDocument($taxDocument)
    {
        $this->data->holder->taxDocument = $taxDocument;

        return $this;
    }

    /**
     * @param $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->data->holder->phone = $phone;

        return $this;
    }

    /**
     * @param $mobileNumber
     * @return $this
     */
    public function setMobile($mobileNumber)
    {
        $this->data->holder->mobile = $mobileNumber;

        return $this;
    }

    /**
     * @param $tradeName
     * @return $this
     */
    public function setTradeName($tradeName)
    {
        $this->data->holder->company->tradeName = $tradeName;

        return $this;
    }

    /**
     * @param $tradeName
     * @return $this
     */
    public function setCompanyTradeName($tradeName)
    {
        $this->data->holder->company->tradeName = $tradeName;

        return $this;
    }

    /**
     * @param $companyFullName
     * @return $this
     */
    public function setCompanyFullName($companyFullName)
    {
        $this->data->holder->company->fullName = $companyFullName;

        return $this;
    }

    /**
     * @param $companyTaxDocument
     * @return $this
     */
    public function setCompanyTaxDocument($companyTaxDocument)
    {
        $this->data->holder->company->taxDocument = $companyTaxDocument;

        return $this;
    }

    /**
     * @param $businessTypeId
     * @return $this
     */
    public function setBusinessTypeId($businessTypeId)
    {
        $this->data->holder->company->businessTypeId = $businessTypeId;

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
    public function setStreetNumber($addStreetNumber)
    {
        $this->data->address->streetNumber = $addStreetNumber;

        return $this;
    }

    /**
     * @param $addZipCode
     * @return $this
     */
    public function setZipCode($addZipCode)
    {
        $this->data->address->zipCode = $addZipCode;

        return $this;
    }

    /**
     * @param $bankNumber
     * @return $this
     */
    public function setBankNumber($bankNumber)
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
    public function setBankBranchNumber($bankBranchNumber)
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
     * @param $userEmail
     * @return $this
     */
    public function setUserEmail($userEmail)
    {
        $this->data->user->email = $userEmail;

        return $this;
    }

    /**
     * @param $userPassword
     * @return $this
     */
    public function setUserPassword($userPassword)
    {
        $this->data->user->password = $userPassword;

        return $this;
    }

    /**
     * @param $businessActivityId
     * @return $this
     */
    public function setBusinessActivityId($businessActivityId)
    {
        $this->data->businessActivityId = $businessActivityId;

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
     * @return mixed
     */
    public function createHolderAccount()
    {
        $urlPath = sprintf("%s/%s/%s", self::ACCOUNT_VERSION, $this->paggcerto->getApplicationNumber(),
            self::SIGNUP_SELLER);
        return $this->createRequest($urlPath);
    }

    /**
     * @return mixed|void
     */
    protected function initialize()
    {
        $this->data = new stdClass();
        $this->data->holder = new stdClass();
        $this->data->address = new stdClass();
        $this->data->bankAccount = new stdClass();
        $this->data->user = new stdClass();
        $this->data->holder->company = new stdClass();
    }

    /**
     * @param stdClass $response
     * @return mixed|void
     */
    protected function populate(stdClass $response)
    {
        $holderAccount = clone $this;
        $holderAccount->data->holder = new stdClass();

        $holder = $this->getIfSet("holder", $response);

    }
}