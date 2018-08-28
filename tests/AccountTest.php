<?php
/**
 * Created by PhpStorm.
 * User: marcus.vinicius
 * Date: 27/08/2018
 * Time: 13:47
 */

namespace Paggcerto\Tests;

use Paggcerto\Auth\Auth;
use Paggcerto\Paggcerto;
use Paggcerto\Tests\Mocks\PaggcertoMock;

class AccountTest extends TestCase
{
    public function testShouldCreateAccount()
    {
        $paggcerto = new Paggcerto(new Auth(), "vL", PaggcertoMock::SIGNUP_SELLER_MOCK);
        $paggcerto->createNewSession();

        $account = $paggcerto
            ->account()
            ->createHolderAccount();

        $this->assertNotEmpty($account);
        $this->assertEquals("Valentina Santos", $account->holder->fullName);
        $this->assertEquals("F", $account->holder->gender);
        $this->assertEquals("927.228.895-95", $account->holder->taxDocument);
        $this->assertEquals("(79) 2946-7954", $account->holder->phone);
        $this->assertEquals("(79) 98827-7241", $account->holder->mobile);
        $this->assertEquals(false, $account->holder->blacklist);
        $this->assertEquals("Esportes ME", $account->holder->company->tradeName);
        $this->assertEquals("Mariana e Emanuelly Esportes ME", $account->holder->company->fullName);
        $this->assertEquals("94.467.995/0001-49", $account->holder->company->taxDocument);
        $this->assertEquals("vL", $account->holder->company->businessType->id);
        $this->assertEquals("Sociedade Empresária Limitada", $account->holder->company->businessType->name);
        $this->assertEquals("Re", $account->businessActivity->id);
        $this->assertEquals("Inacio Barbosa", $account->address->district);
        $this->assertEquals("R Manoel De Oliveira Martins", $account->address->line1);
        $this->assertEquals("Ap 001, Cleveland House", $account->address->line2);
        $this->assertEquals("229", $account->address->streetNumber);
        $this->assertEquals("49040-830", $account->address->zipCode);
        $this->assertEquals("Aracaju", $account->address->city->name);
        $this->assertEquals("2800308", $account->address->city->code);
        $this->assertEquals("001", $account->bankAccount->bankNumber);
        $this->assertEquals("Banco do Brasil S.A.", $account->bankAccount->bankName);
        $this->assertEquals("123456-78", $account->bankAccount->accountNumber);
        $this->assertEquals("1234-5", $account->bankAccount->bankBranchNumber);
        $this->assertEquals(null, $account->bankAccount->variation);
        $this->assertEquals("corrente", $account->bankAccount->type);
        $this->assertEquals(32, $account->account->transferPlan->days);
        $this->assertEquals(true, $account->account->transferPlan->anticipated);
        $this->assertEquals(false, $account->bankAccount->isJuristic);
        $this->assertEquals(true, $account->account->active);
        $this->assertEquals(true, $account->account->approved);
        $this->assertEquals(false, $account->account->freeTrial);
        $this->assertEquals(false, $account->account->balanceBlocked);
        $this->assertEquals(true, $account->account->oldAnticipationPlan);
        $this->assertEquals(0, $account->account->vanBanese);
        $this->assertEquals("Esportes ME", $account->account->softdescriptor);
        $this->assertEquals("123.123.123.154", $account->registrationOrigin->ip);
        $this->assertEquals(null, $account->registrationOrigin->timeOnScreen);
        $this->assertEquals("insomnia/5.15.0", $account->registrationOrigin->userAgent);
        $this->assertEquals("Desktop", $account->registrationOrigin->device);
        $this->assertEquals("Generic", $account->registrationOrigin->browser);
        $this->assertEquals(null, $account->registrationOrigin->platform);
        $this->assertEquals(null, $account->registrationOrigin->engine);
        $this->assertEquals("N9", $account->registrationOrigin->marketingMedia->id);
        $this->assertEquals("Instagram", $account->registrationOrigin->marketingMedia->name);
    }
}
