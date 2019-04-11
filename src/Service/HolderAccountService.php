<?php
/**
 * User: erick.antunes
 * Date: 24/07/2018
 * Time: 15:51
 */

namespace Paggcerto\Service;

use Paggcerto\Paggcerto;
use Requests;
use stdClass;

class HolderAccountService extends PaggcertoAccountApiService
{
    const SIGNUP_SELLER = self::ACCOUNT_VERSION . "/" . Paggcerto::APPLICATION_ID . "/signup/seller";
    const SETUP_HOLDER_ACCOUNT = self::ACCOUNT_VERSION . "/presets";

    public function __construct(Paggcerto $paggcerto)
    {
        parent::__construct($paggcerto);
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
    public function setHolderBirthDate($birthDate)
    {
        $this->data->holder->birthDate = $birthDate;

        return $this;
    }

    /**
     * @param $gender
     * @return $this
     */
    public function setHolderGender($gender)
    {
        $this->data->holder->gender = $gender;

        return $this;
    }

    /**
     * @param $taxDocument
     * @return $this
     */
    public function setHolderTaxDocument($taxDocument)
    {
        $this->data->holder->taxDocument = $taxDocument;

        return $this;
    }

    /**
     * @param $phone
     * @return $this
     */
    public function setHolderPhone($phone)
    {
        $this->data->holder->phone = $phone;

        return $this;
    }

    public function setMarketingMediaId($marketingId)
    {
        $this->data->marketingMediaId = $marketingId;

        return $this;
    }

    /**
     * @param $comercialName
     * @return $this
     */
    public function setHolderComercialName($comercialName)
    {
        $this->data->comercialName = $comercialName;

        return $this;
    }

    /**
     * @param $softDescriptor
     * @return $this
     */
    public function setSoftDescriptor($softDescriptor)
    {
        $this->data->softDescriptor = $softDescriptor;

        return $this;
    }

    /**
     * @param $mobileNumber
     * @return $this
     */
    public function setHolderMobile($mobileNumber)
    {
        $this->data->holder->mobile = $mobileNumber;
        $this->data->mobile = $mobileNumber;

        return $this;
    }

    /**
     * @param $tradeName
     * @return $this
     */
    public function setHolderTradeName($tradeName)
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
     * @param $isJuridic
     * @return $this
     */
    public function setBankAccountIsJuridic($isJuridic)
    {
        $this->data->bankAccount->isJuristic = $isJuridic;

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
        $this->data->password = $userPassword;

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
     * @param $days
     * @return $this
     */
    public function setTransferPlanDays($days)
    {
        $this->data->transferPlan->days = $days;

        return $this;
    }

    /**
     * @param $anticipated
     * @return $this
     */
    public function setTransferPlanAnticipated($anticipated)
    {
        $this->data->transferPlan->anticipated = $anticipated;

        return $this;
    }

    /**
     * @param $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->data->phone = $phone;

        return $this;
    }

    /**
     * @param $mobilePhone
     * @return $this
     */
    public function setMobile($mobilePhone)
    {
        $this->data->mobile = $mobilePhone;

        return $this;
    }

    /**
     * @param $comercialName
     * @return $this
     */
    public function setComercialName($comercialName)
    {
        $this->data->comercialName = $comercialName;

        return $this;
    }


    /**
     * @return mixed
     */
    public function createHolderAccount()
    {
        return $this->httpRequest(self::SIGNUP_SELLER, Requests::POST, $this->data);
    }

    /**
     *
     */
    public function setupHolderAccount()
    {
        $this->httpRequest(self::SETUP_HOLDER_ACCOUNT, Requests::POST, $this->data);
    }

    /**
     * @return mixed
     */
    public function getSetupHolderAccount()
    {
        return $this->httpRequest(self::SETUP_HOLDER_ACCOUNT, Requests::GET);
    }

    /**
     * @param stdClass $response
     * @return mixed|void
     */
    protected function fillEntity(stdClass $response)
    {
        $holderAccount = clone $this;
        $holderAccount->data = new stdClass();
        $listKeys = ["holder", "address", "bankAccount", "account", "registrationOrigin", "businessActivity"];
        $this->hydratorObject($holderAccount->data,$listKeys,$response);

        return $holderAccount->data;
    }

    /**
     * @return mixed|void
     */
    protected function init()
    {
        $this->data = new stdClass();
        $this->data->holder = new stdClass();
        $this->data->address = new stdClass();
        $this->data->bankAccount = new stdClass();
        $this->data->user = new stdClass();
        $this->data->holder->company = new stdClass();
        $this->data->transferPlan = new stdClass();
    }
}