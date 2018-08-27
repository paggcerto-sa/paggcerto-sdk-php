<?php

namespace Paggcerto;

use Paggcerto\Auth\ToConnect;
use Paggcerto\Service\BankService;
use Paggcerto\Service\BusinessActivityService;
use Paggcerto\Service\BusinessTypeService;
use Paggcerto\Service\CityService;
use Paggcerto\Service\HolderAccountService;

class Paggcerto extends ToConnect
{
    const ACCOUNT_ENDPOINT_SANDBOX = "http://account.sandbox.paggcerto.com.br/api/";
    const ACCOUNT_ENDPOINT_PRODUCTION = "https://account.paggcerto.com.br/api/";
    const PAYMENTS_ENDPOINT_SANDBOX = "http://payments.sandbox.paggcerto.com.br/api/";
    const PAYMENTS_ENDPOINT_PRODUCTION = "https://payments.paggcerto.com.br/api/";
    const CLIENT = "PaggcertoPhpSdk";
    const CLIENT_VERSION = "0.0.1-beta";

    public function account()
    {
        return new HolderAccountService($this);
    }

    public function city()
    {
        return new CityService($this);
    }

    public function businessType()
    {
        return new BusinessTypeService($this);
    }

    public function bank()
    {
        return new BankService($this);
    }

    public function businessActivity()
    {
        return new BusinessActivityService($this);
    }
}
