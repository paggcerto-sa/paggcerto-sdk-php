<?php
/**
 * User: erick.antunes
 * Date: 31/07/2018
 * Time: 10:07
 */

namespace Paggcerto\Tests;


use Paggcerto\Auth\Auth;
use Paggcerto\Auth\NoAuth;
use Paggcerto\Paggcerto;

/**
 * Class ComplementaryMethodsTest
 * @package Paggcerto\Tests
 */
class ComplementaryMethodsTest extends TestCase
{
    public function testMustGetCities()
    {
        $paggcerto = new Paggcerto(new NoAuth());

        $cities = $paggcerto->city()->getRequest(["SP"]);

        $this->assertNotEmpty($cities);
        $this->assertTrue(count($cities) > 0);
    }

    public function testMustGetBussinesType()
    {
        $paggcerto = new Paggcerto(new NoAuth());

        $businessTypes = $paggcerto->businessType()->getRequest();

        $this->assertNotEmpty($businessTypes);
        $this->assertTrue(count($businessTypes) > 0);
    }

    public function testMustGetBanks()
    {
        $paggcerto = new Paggcerto(new NoAuth());

        $banks = $paggcerto->bank()->getRequest();

        $this->assertNotEmpty($banks);
        $this->assertTrue(count($banks) > 0);
    }

    public function testMustGetBusinessActivities()
    {
        $paggcerto = new Paggcerto(new NoAuth());

        $businessActivities = $paggcerto->businessActivity()->getRequest();

        $this->assertNotEmpty($businessActivities);
        $this->assertTrue(count($businessActivities) > 0);
    }

    public function testMustGetMarketingMedias()
    {
        $paggcerto = new Paggcerto(new NoAuth());

        $marketingMedias = $paggcerto->marketingMedia()->getRequest();

        $this->assertNotEmpty($marketingMedias);
        $this->assertTrue(count($marketingMedias) > 0);
    }
}