<?php
/**
 * User: erick.antunes
 * Date: 31/07/2018
 * Time: 10:07
 */

namespace Paggcerto\Tests;


use Paggcerto\Auth\Auth;
use Paggcerto\Paggcerto;
use Paggcerto\Service\CityService;

class CityTest extends TestCase
{
    public function testMustGetCities()
    {
        $paggcerto = new Paggcerto(new Auth(), "vL");
        $paggcerto->createNewSession();
        $cities = $paggcerto->city()->getRequest(sprintf(CityService::SEARCH_CITIES, "SE"));
        $paggcerto->city()->

        $this->assertNotEmpty($cities);
    }
}