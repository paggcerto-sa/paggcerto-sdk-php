<?php
/**
 * User: erick.antunes
 * Date: 13/03/2019
 * Time: 11:57
 */

namespace Paggcerto\Tests;


use Paggcerto\Auth\Auth;
use Paggcerto\Paggcerto;

class ReportsTest extends TestCase
{
    public function testShouldPayAuthorized()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->cardPayment()
            ->setAmount(100)
            ->addCard("João blah", "5111925270937702", 12,
                2023, 50, "035", 1, true)
            ->setPaymentDeviceSerialNumber("8000151509001953")
            ->setPaymentDeviceModel("mp5")
            ->isAuthorizedSale()
            ->setDaysLimitAuthorization(28)
            ->pay();

        $this->assertEquals("pending", $result->status);
        $this->assertEquals(100, $result->amount);
        $this->assertEquals(50, $result->amountPaid);
        $this->assertEquals(true, $result->cancelable);
        $this->assertEquals(1, count($result->cardTransactions));
        $this->assertEquals(0, count($result->bankSlips));

        return $result;
    }

    /**
     * @depends testShouldPayAuthorized
     */
    public function testShouldGetPaymentDetails($payment)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->reportsManagement()
            ->setPaymentId($payment->id)
            ->getPaymentDetails();

        $this->assertEquals("pending", $result->status);
        $this->assertEquals(100, $result->amount);
        $this->assertEquals(50, $result->amountPaid);
        $this->assertEquals(true, $result->cancelable);
        $this->assertEquals(1, count($result->cardTransactions));
        $this->assertEquals(0, count($result->bankSlips));

        return $result;
    }
}