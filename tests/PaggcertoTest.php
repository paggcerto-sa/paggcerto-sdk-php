<?php

namespace Paggcerto\Tests;

use Paggcerto\Auth\Auth;
use Paggcerto\Paggcerto;

class PaggcertoTest extends TestCase
{
    public function testProvisore()
    {
        $this->assertEquals("https://account.sandbox.paggcerto.com.br/api/", Paggcerto::ACCOUNT_ENDPOINT_SANDBOX);
    }

    public function testConnect()
    {
        $paggSandbox = new Paggcerto(new Auth(), "vL");

        $cities = $paggSandbox->createNewSession();
        $paggSandbox->accounts()
            ->setHolderFullName("Erick Antunes")
            ->setBirthDate("1999-09-06")
            ->setGender("M")
            ->setTaxDocument("202.932.490-67")
            ->setPhone("7930303030")
            ->setMobile("79999999999")
            ->setTradeName("Empresa fantasia " . rand(0, 99999999))
            ->setCompanyFullName("Empresa fantasia compania limitada");

        $this->assertTrue(true);
    }
}
