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
use Paggcerto\Service\ReportsService;
use Paggcerto\Service\RoleConceptService;
use Paggcerto\Service\RoleService;
use Paggcerto\Service\SplitService;
use Paggcerto\Service\WebhooksService;

class Paggcerto extends ToConnect
{
    const ACCOUNT_ENDPOINT_SANDBOX = "https://account.sandbox.pagcerto.com.br/api/";
    const ACCOUNT_ENDPOINT_PROD = "https://account.pagcerto.com.br/api/";
    const PAYMENTS_ENDPOINT_SANDBOX = "https://payments.sandbox.pagcerto.com.br/api/";
    const PAYMENTS_ENDPOINT_PROD = "https://payments.pagcerto.com.br/api/";
    const WEBHOOKS_ENDPOINT_SANDBOX = "https://webhooks.sandbox.pagcerto.com.br/api/";
    const WEBHOOKS_ENDPOINT_PROD = "https://webhooks.pagcerto.com.br/api/";

    const CLIENT = "PagcertoPhpSdk";
    const CLIENT_VERSION = "1.1.7";
    const APPLICATION_ID = "Lk";
    const ENDPOINT_SANDBOX = "sandbox";
    const ENDPOINT_PROD = "prod";
    const ENDPOINT_MOCK = "mock";
    private $appId = self::APPLICATION_ID;

    /**
     * Paggcerto constructor.
     * @param Authentication $paggcertoAuth
     * @param string $endpointEnvironment
     */
    public function __construct(Authentication $paggcertoAuth, $endpointEnvironment = self::ENDPOINT_SANDBOX)
    {
        parent::__construct($paggcertoAuth, $endpointEnvironment);

        if ($paggcertoAuth instanceof Auth) {
            $token = $this->authentication()
                ->authCredentials($paggcertoAuth->getEmail(), $paggcertoAuth->getPassword(), $paggcertoAuth->getAppId())
                ->token;
            $paggcertoAuth->setToken($token);

            $this->appId = $paggcertoAuth->getAppId() != null ? $paggcertoAuth->getAppId() : self::APPLICATION_ID;
        }

        if ($paggcertoAuth instanceof AuthHash) {
            $token = $this->authentication()
                ->authHash($paggcertoAuth->getHash(), $this->appId, $paggcertoAuth->getAppId())
                ->token;
            $paggcertoAuth->setToken($token);

            $this->appId = $paggcertoAuth->getAppId() != null ? $paggcertoAuth->getAppId() : self::APPLICATION_ID;
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
        return new HolderAccountService($this, $this->appId);
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

    /**
     * @return WebhooksService
     */
    public function webhooksManagement()
    {
        return new WebhooksService($this);
    }

    /**
     * @return ReportsService
     */
    public function reportsManagement()
    {
        return new ReportsService($this);
    }

	/**
	 * @return SplitService
	 */
	public function split()
	{
		return new SplitService($this);
	}
}
