<?php

namespace Paggcerto;

use Paggcerto\Auth\Auth;
use Paggcerto\Auth\AuthHash;
use Paggcerto\Auth\ToConnect;
use Paggcerto\Contracts\Authentication;
use Paggcerto\Service\AuthService;
use Paggcerto\Service\BankService;
use Paggcerto\Service\BankSlipPaymentService;
use Paggcerto\Service\BusinessActivityService;
use Paggcerto\Service\BusinessTypeService;
use Paggcerto\Service\CardManagementService;
use Paggcerto\Service\CardPaymentService;
use Paggcerto\Service\CityService;
use Paggcerto\Service\HolderAccountService;
use Paggcerto\Service\MarketingMediaService;
use Paggcerto\Service\PaymentService;
use Paggcerto\Service\RoleConceptService;
use Paggcerto\Service\RoleService;

class Paggcerto extends ToConnect
{
    const ACCOUNT_ENDPOINT_SANDBOX = "http://account.sandbox.paggcerto.com.br/api/";
    const ACCOUNT_ENDPOINT_PROD = "https://account.paggcerto.com.br/api/";
    const PAYMENTS_ENDPOINT_SANDBOX = "http://payments.sandbox.paggcerto.com.br/api/";
    const PAYMENTS_ENDPOINT_PROD = "https://payments.paggcerto.com.br/api/";
    const CLIENT = "PaggcertoPhpSdk";
    const CLIENT_VERSION = "0.0.1-beta";
    const APPLICATION_ID = "Lk";
    const ENDPOINT_SANDBOX = "sandbox";
    const ENDPOINT_PROD = "prod";
    const ENDPOINT_MOCK = "mock";

    /**
     * Paggcerto constructor.
     * @param Authentication $paggcertoAuth
     * @param string $endpoint
     */
    public function __construct(Authentication $paggcertoAuth, $endpointEnvironment = self::ENDPOINT_SANDBOX)
    {
        parent::__construct($paggcertoAuth, $endpointEnvironment);

        if ($paggcertoAuth instanceof Auth) {
            $token = $this->authentication()
                ->authCredentials($paggcertoAuth->getEmail(), $paggcertoAuth->getPassword())
                ->token;
            $paggcertoAuth->setToken($token);
        }

        if ($paggcertoAuth instanceof AuthHash) {
            $token = $this->authentication()
                ->authHash($paggcertoAuth->getHash())
                ->token;
            $paggcertoAuth->setToken($token);
        }

        parent::__construct($paggcertoAuth, $endpointEnvironment);
    }

    /**
     * @return AuthService
     */
    public function authentication()
    {
        return new AuthService($this);
    }

    /**
     * @return HolderAccountService
     */
    public function account()
    {
        return new HolderAccountService($this);
    }

    /**
     * @return CityService
     */
    public function city()
    {
        return new CityService($this);
    }

    /**
     * @return BusinessTypeService
     */
    public function businessType()
    {
        return new BusinessTypeService($this);
    }

    /**
     * @return BankService
     */
    public function bank()
    {
        return new BankService($this);
    }

    /**
     * @return BusinessActivityService
     */
    public function businessActivity()
    {
        return new BusinessActivityService($this);
    }

    /**
     * @return MarketingMediaService
     */
    public function marketingMedia()
    {
        return new MarketingMediaService($this);
    }

    /**
     * @return RoleService
     */
    public function role()
    {
        return new RoleService($this);
    }

    /**
     * @return RoleConceptService
     */
    public function roleConcept()
    {
        return new RoleConceptService($this);
    }

    /**
     * @return CardPaymentService
     */
    public function cardPayment()
    {
        return new CardPaymentService($this);
    }

    /**
     * @return BankSlipPaymentService
     */
    public function bankSlipPayment()
    {
        return new BankSlipPaymentService($this);
    }

    /**
     * @return PaymentService
     */
    public function payment()
    {
        return new PaymentService($this);
    }

    /**
     * @return CardManagementService
     */
    public function cardManagement()
    {
        return new CardManagementService($this);
    }
}
