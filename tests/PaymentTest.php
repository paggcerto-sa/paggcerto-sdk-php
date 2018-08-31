<?php
/**
 * User: erick.antunes
 * Date: 30/08/2018
 * Time: 12:32
 */

namespace Paggcerto\Tests;

use Paggcerto\Auth\Auth;
use Paggcerto\Paggcerto;

class PaymentTest extends TestCase
{
    public function testShouldGetCardsBrands()
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));

        $result = $paggcerto->cardPayment()
            ->getCardsBrands();

        $this->assertGreaterThan(0, count($result->bins));
    }
}