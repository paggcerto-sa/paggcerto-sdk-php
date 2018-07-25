<?php

namespace Paggcerto;

use Paggcerto\Resource\HolderAccountResource;

class Paggcerto
{
    const ACCOUNT_ENDPOINT_SANDBOX = "https://account.sandbox.paggcerto.com.br/";
    const ACCOUNT_ENDPOINT_PRODUCTION = "https://account.paggcerto.com.br/";
    const PAYMENTS_ENDPOINT_SANDBOX = "https://payments.sandbox.paggcerto.com.br/";
    const PAYMENTS_ENDPOINT_PRODUCTION = "https://payments.paggcerto.com.br/";
    const CLIENT = "PaggcertoPhpSdk";
    const CLIENT_VERSION = "0.0.1-beta";

    public function accounts()
    {
        return new HolderAccountResource($this);
    }
}
