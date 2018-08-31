<?php
/**
 * Created by PhpStorm.
 * User: marcus.vinicius
 * Date: 27/08/2018
 * Time: 13:47
 */

namespace Paggcerto\Tests;

use Paggcerto\Auth\Auth;
use Paggcerto\Auth\AuthHash;
use Paggcerto\Auth\NoAuth;
use Paggcerto\Exceptions\AuthException;
use Paggcerto\Paggcerto;
use Paggcerto\Tests\Mocks\PaggcertoMock;

class AccountTest extends TestCase
{
    public function testShouldGetWhoAmI()
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();
        $whoAmI = $paggcerto->authentication()->whoAmI();

        $this->assertEquals("Erick Antunes", $whoAmI->holder->fullName);
        $this->assertEquals("Gestão de Mensalidades", $whoAmI->application->name);
        $this->assertEquals(true, $whoAmI->account->approved);
        $this->assertEquals("555.746.290-20", $whoAmI->user->taxDocument);
    }

    public function testShouldSetupHolderAcc()
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $paggcerto->account()
            ->setUserPassword("95625845")
            ->setHolderMobile("(79) 99999-9999")
            ->setTransferPlanDays(32)
            ->setTransferPlanAnticipated(true)
            ->setBankAccountBankNumber("001")
            ->setBankAccountNumber("31232156132-12")
            ->setBankAccountBranchNumber("0031")
            ->setBankAccountType("corrente")
            ->setBankAccountIsJuridic(true)
            ->setAddressCityCode("2800308")
            ->setAddressDistrict("Farolândia")
            ->setAddressLine1("Rua Silvio do Espírito Santos Seixas")
            ->setAddressStreetNumber("92")
            ->setAddressZipCode("49030-423")
            ->setupHolderAccount();

        $this->assertTrue(true);
    }

    public function testShouldCreateAccount()
    {
        $paggcerto = new Paggcerto(new NoAuth(), PaggcertoMock::SIGNUP_SELLER);
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
        $this->assertEquals(null, $account->registrationOrigin->timeOnScreen);
        $this->assertEquals("insomnia/5.15.0", $account->registrationOrigin->userAgent);
        $this->assertEquals("Desktop", $account->registrationOrigin->device);
        $this->assertEquals("Generic", $account->registrationOrigin->browser);
        $this->assertEquals(null, $account->registrationOrigin->platform);
        $this->assertEquals(null, $account->registrationOrigin->engine);
        $this->assertEquals("N9", $account->registrationOrigin->marketingMedia->id);
        $this->assertEquals("Instagram", $account->registrationOrigin->marketingMedia->name);
    }

    public function testShouldGetSetupHolderAccountMock()
    {
        $paggcerto = new Paggcerto(new NoAuth(), PaggcertoMock::GET_PRESTES);
        $paggcerto->createNewSession();

        $presets = $paggcerto->account()->getSetupHolderAccount();

        $this->assertNotEmpty($presets);
        $this->assertEquals("Valentina Santos", $presets->holder->fullName);
        $this->assertEquals("F", $presets->holder->gender);
        $this->assertEquals("927.228.895-95", $presets->holder->taxDocument);
        $this->assertEquals("(79) 2946-7954", $presets->holder->phone);
        $this->assertEquals("(79) 98827-7241", $presets->holder->mobile);
        $this->assertEquals("Esportes ME", $presets->holder->company->tradeName);
        $this->assertEquals("Mariana e Emanuelly Esportes ME", $presets->holder->company->fullName);
        $this->assertEquals("94.467.995/0001-49", $presets->holder->company->taxDocument);
        $this->assertEquals("Inacio Barbosa", $presets->address->district);
        $this->assertEquals("R Manoel De Oliveira Martins", $presets->address->line1);
        $this->assertEquals("Ap 001, Cleveland House", $presets->address->line2);
        $this->assertEquals("229", $presets->address->streetNumber);
        $this->assertEquals("49040-830", $presets->address->zipCode);
        $this->assertEquals("2800308", $presets->address->city->code);
        $this->assertEquals("Aracaju", $presets->address->city->name);
        $this->assertEquals("SE", $presets->address->city->state);
        $this->assertEquals("104", $presets->bankAccount->bankNumber);
        $this->assertEquals("Caixa Econômica Federal.", $presets->bankAccount->bankName);
        $this->assertEquals("02857254642-5", $presets->bankAccount->accountNumber);
        $this->assertEquals("1500-1", $presets->bankAccount->bankBranchNumber);
        $this->assertEquals(null, $presets->bankAccount->variation);
        $this->assertEquals("corrente", $presets->bankAccount->type);
        $this->assertEquals(false, $presets->bankAccount->isJuristic);
        $this->assertEquals(true, $presets->account->active);
        $this->assertEquals(true, $presets->account->approved);
        $this->assertEquals(false, $presets->account->freeTrial);
        $this->assertEquals(false, $presets->account->balanceBlocked);
        $this->assertEquals(true, $presets->account->oldAnticipationPlan);
        $this->assertEquals(0, $presets->account->vanBanese);
        $this->assertEquals("Esportes ME", $presets->account->softdescriptor);
    }

    public function testShouldGetSetupHolderAccountSandbox()
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $presets = $paggcerto->account()->getSetupHolderAccount();

        $this->assertNotEmpty($presets);
        $this->assertEquals("Erick Antunes", $presets->holder->fullName);
        $this->assertEquals("M", $presets->holder->gender);
        $this->assertEquals("555.746.290-20", $presets->holder->taxDocument);
        $this->assertNull($presets->holder->phone);
        $this->assertEquals("(79) 99999-9999", $presets->holder->mobile);
        $this->assertEquals("Universidade Life", $presets->holder->company->tradeName);
        $this->assertEquals("Nanitec operações limitadas", $presets->holder->company->fullName);
        $this->assertEquals("15.150.963/0001-49", $presets->holder->company->taxDocument);
        $this->assertEquals("Farolândia", $presets->address->district);
        $this->assertEquals("Rua Silvio do Espírito Santos Seixas", $presets->address->line1);
        $this->assertNull($presets->address->line2);
        $this->assertEquals("92", $presets->address->streetNumber);
        $this->assertEquals("49030-423", $presets->address->zipCode);
        $this->assertEquals("2800308", $presets->address->city->code);
        $this->assertEquals("Aracaju", $presets->address->city->name);
        $this->assertEquals("SE", $presets->address->city->state);
        $this->assertEquals("001", $presets->bankAccount->bankNumber);
        $this->assertEquals("Banco do Brasil S.A.", $presets->bankAccount->bankName);
        $this->assertEquals("31232156132-12", $presets->bankAccount->accountNumber);
        $this->assertEquals("0031", $presets->bankAccount->bankBranchNumber);
        $this->assertEquals(null, $presets->bankAccount->variation);
        $this->assertEquals("corrente", strtolower($presets->bankAccount->type));
        $this->assertEquals(true, $presets->bankAccount->isJuristic);
        $this->assertEquals(true, $presets->account->active);
        $this->assertEquals(true, $presets->account->approved);
        $this->assertEquals(true, $presets->account->freeTrial);
        $this->assertEquals(false, $presets->account->balanceBlocked);
        $this->assertEquals(false, $presets->account->oldAnticipationPlan);
        $this->assertEquals(0, $presets->account->vanBanese);
        $this->assertNull($presets->account->softDescriptor);
    }

    public function testShouldOAuthExceptionWithHash()
    {
        try {
            $paggcerto = new Paggcerto(new AuthHash("128ecf542a35ac5270a87dc740918404"), PaggcertoMock::SIGNIN_HASH);
            $paggcerto->createNewSession();
            $this->assertEquals("Ehjikkja585569779efwrf.ihuheyvvc872622791ndbdehv", $paggcerto->getSession()->options["auth"]->getToken());
        } catch (AuthException $e) {
        }
    }

    /**
     * @expectedExceptionCode 400
     * @expectedException  \Exception
     * @expectedExceptionMessage Necessary pass a hash to authenticate.
     */
    public function testShouldOAuthExceptionWithNullable()
    {
        new AuthHash(null);
    }

    /**
     * @expectedExceptionCode 400
     * @expectedException  \Exception
     * @expectedExceptionMessage Necessary pass a hash to authenticate.
     */
    public function testShouldOAuthExceptionWithNotString()
    {
        new AuthHash([]);
    }
}
