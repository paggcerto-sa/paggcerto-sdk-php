<?php
/**
 * User: erick.antunes
 * Date: 31/07/2018
 * Time: 10:07
 */

namespace Paggcerto\Tests;


use Paggcerto\Auth\Auth;
use Paggcerto\Paggcerto;
use Paggcerto\Service\BankService;
use Paggcerto\Service\BusinessTypeService;
use Paggcerto\Service\CityService;

class ComplementaryMethodsTest extends TestCase
{
    public function testMustGetCities()
    {
        $paggcerto = new Paggcerto(new Auth(), "vL");
        $paggcerto->createNewSession();
        $cities = $paggcerto->city()->getRequest(sprintf(CityService::SEARCH_CITIES, "SE"));

        $this->assertNotEmpty($cities);
        $this->assertTrue(count($cities) > 0);
    }

    public function testMustGetBussinesType()
    {
        $paggcerto = new Paggcerto(new Auth(), "vL");
        $paggcerto->createNewSession();
        $businessTypes = $paggcerto->businessType()->getRequest(BusinessTypeService::SEARCH_BUSINESS_TYPES);

        $this->assertNotEmpty($businessTypes);
        $this->assertTrue(count($businessTypes) > 0);
    }

    public function testMustGetBanks()
    {
        $paggcerto = new Paggcerto(new Auth(), "vL");
        $paggcerto->createNewSession();
        $banks = $paggcerto->banks()->getRequest(BankService::SEARCH_BANKS);

        $this->assertNotEmpty($banks);
        $this->assertTrue(count($banks) > 0);
    }
}