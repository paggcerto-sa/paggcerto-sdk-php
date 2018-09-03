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
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->cardPayment()
            ->getCardsBrands();

        $this->assertGreaterThan(0, count($result->bins));
    }

    public function testShouldSimulatePayment()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->cardPayment()
            ->setAmount(100)
            ->setInstallments(2)
            ->setCardBrand("visa")
            ->setCredit(true)
            ->setCustomerPaysFee(true)
            ->setPinpad(false)
            ->paySimulate();

        $this->assertEquals(111.11, $result->amountCharged);
        $this->assertEquals(100, $result->amountReceived);
    }

    public function testShouldPay()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->cardPayment()
            ->setAmount(100)
            ->addCard("João blah", "4929915748910899", 12,
                2018, 50, "035", 1, true)
            ->setPaymentDeviceSerialNumber("8000151509001953")
            ->setPaymentDeviceModel("mp5")
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
     * @depends testShouldPay
     */
    public function testShouldSendReceipt($payment)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $paggcerto->cardPayment()
            ->setNsu($payment->cardTransactions[0]->nsu)
            ->setEmail("richter@belmont.com")
            ->sendReceipt();

        $this->assertTrue(true);
    }

    /**
     * @depends testShouldPay
     */
    public function testShouldPayContinue($payment)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->cardPayment()
            ->setPaymentId($payment->id)
            ->addCard("Maria blah", "5111925270937702", 5,
                2020, 50, "587", 1, true)
            ->payContinue();

        $this->assertEquals("paid", $result->status);
        $this->assertEquals(100, $result->amount);
        $this->assertEquals(100, $result->amountPaid);
        $this->assertEquals(true, $result->cancelable);
        $this->assertEquals(2, count($result->cardTransactions));
        $this->assertEquals(0, count($result->bankSlips));
    }

    /**
     * @depends testShouldPay
     */
    public function testShouldCancelTransaction($payment)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->cardPayment()
            ->setNsu($payment->cardTransactions[0]->nsu)
            ->cardTransactionCancel();

        $this->assertEquals("canceled", $result->cardTransactions[0]->status);
    }

    /**
     * @depends testShouldPay
     */
    public function testShouldPayCancel($payment)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->cardPayment()
            ->setPaymentId($payment->id)
            ->payCancel();

        $this->assertEquals("canceled", $result->status);
        $this->assertEquals(100, $result->amount);
        $this->assertEquals(false, $result->cancelable);
        $this->assertEquals(2, count($result->cardTransactions));
        $this->assertEquals(0, count($result->bankSlips));
    }
}