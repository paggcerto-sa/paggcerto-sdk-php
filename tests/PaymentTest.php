<?php
/**
 * User: erick.antunes
 * Date: 30/08/2018
 * Time: 12:32
 */

namespace Paggcerto\Tests;

use DateInterval;
use DateTime;
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

        $this->assertEquals(111.44, $result->amountCharged);
        $this->assertEquals(100, $result->amountReceived);
    }

    public function testShouldPay()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->cardPayment()
            ->setAmount(100)
            ->addCard("João blah", "4929915748910899", 12,
                2020, 50, "035", 1, true)
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

    public function testShouldPayAuthorized()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->cardPayment()
            ->setAmount(100)
            ->addCard("João blah", "4929915748910899", 12,
                2020, 50, "035", 1, true)
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
    public function testShouldPaymentCancel($payment)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->payment()
            ->setPaymentId($payment->id)
            ->paymentCancel();

        $this->assertEquals("canceled", $result->status);
        $this->assertEquals(100, $result->amount);
        $this->assertEquals(false, $result->cancelable);
        $this->assertEquals(2, count($result->cardTransactions));
        $this->assertEquals(0, count($result->bankSlips));
    }

    public function testShouldPayConclusion()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->cardPayment()
            ->setAmount(100)
            ->addCard("João blah", "4929915748910899", 12,
                2020, 50, "035", 1, true)
            ->setPaymentDeviceSerialNumber("8000151509001953")
            ->setPaymentDeviceModel("mp5")
            ->pay();

        $conclusion = $paggcerto->payment()
            ->setPaymentId($result->id)
            ->setAdditionalInformation("Test sdk php")
            ->setNote("teste")
            ->payFinalize();

        $this->assertEquals("paid", $conclusion->status);
    }

    public function testShouldBankSlipPay()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $dateDue = (new DateTime())->add(new DateInterval("P10D"));
        $result = $paggcerto->bankSlipPayment()
            ->setDiscount(2.55)
            ->setDiscountDays(30)
            ->setFines(5)
            ->setInterest(3)
            ->setAcceptedUntil(15)
            ->addPayer("Rodrigo Alves", "953.262.300-03")
            ->addInstallment($dateDue->format("Y-m-d"), 100)
            ->setInstructions("PHP SDK Test")
            ->setNote("Oi")
            ->pay();

        $this->assertEquals(100, $result->payments[0]->amount);
        $this->assertEquals("pending", $result->payments[0]->status);
        $this->assertEquals( 1, count($result->payments[0]->bankSlips));
        $this->assertEquals(true, $result->payments[0]->cancelable);

        return $result->payments[0];
    }

    /**
     * @depends testShouldBankSlipPay
     */
    public function testShouldBankSlipPDF($bankSlipPayment)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->bankSlipPayment()
            ->setPaymentId($bankSlipPayment->id)
            ->makeBankSlipPDF();

        $this->assertNotNull($result);
    }

    public function testShouldMultiplesBankSlip()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->bankSlipPayment()
            ->addPayment("aP2")
            ->addPayment("REE")
            ->makeMultiplesBankSlipPDF();

        $this->assertNotNull($result);
    }

    /**
     * @depends testShouldBankSlipPay
     */
    public function testShouldBankSlipCancel($bankSlip)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $result = $paggcerto->bankSlipPayment()
            ->setNumber($bankSlip->bankSlips[0]->number)
            ->cancel();

        $this->assertEquals("canceled", $result->status);
        $this->assertEquals(1, count($result->bankSlips));
    }

    public function testShouldBankSlipReplace()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $dateDue = (new DateTime())->add(new DateInterval("P10D"));
        $bankSlipPayResult = $paggcerto->bankSlipPayment()
            ->setDiscount(2.55)
            ->setDiscountDays(30)
            ->setFines(5)
            ->setInterest(3)
            ->setAcceptedUntil(15)
            ->addPayer("Rodrigo Alves", "953.262.300-03")
            ->addInstallment($dateDue->format("Y-m-d"), 100)
            ->setInstructions("PHP SDK Test")
            ->pay();

        $result = $paggcerto->bankSlipPayment()
            ->setNumber($bankSlipPayResult->payments[0]->bankSlips[0]->number)
            ->setDiscountDays(30)
            ->setDiscount(10)
            ->setFines(5)
            ->setInterest(3)
            ->setAcceptedUntil(15)
            ->setDueDate($dateDue->format("Y/m/d"))
            ->setInstructions("PHP SDK test new bankslip date")
            ->bankSlipReplace();


        $this->assertEquals(100, $result->amount);
        $this->assertEquals("pending", $result->status);
        $this->assertEquals(true, $result->cancelable);
        $this->assertEquals(2, count($result->bankSlips));
    }
}