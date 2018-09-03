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
use Paggcerto\Helper\CnpjTool;
use Paggcerto\Paggcerto;
use Paggcerto\Tests\Mocks\PaggcertoMock;

class AccountTest extends TestCase
{
    public function testShouldGetWhoAmI()
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));

        $whoAmI = $paggcerto->authentication()->whoAmI();

        $this->assertEquals("Erick Antunes", $whoAmI->holder->fullName);
        $this->assertEquals("Gestão de Mensalidades", $whoAmI->application->name);
        $this->assertEquals(true, $whoAmI->account->approved);
        $this->assertEquals("555.746.290-20", $whoAmI->user->taxDocument);
    }

    public function testShouldSetupHolderAcc()
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));

        $paggcerto->account()
            ->setUserPassword("95625845")
            ->setPhone("(79) 2946-7954")
            ->setMobile("(79) 99999-9999")
            ->setComercialName("Botique José")
            ->setSoftDescriptor("LIMIT")
            ->setTransferPlanDays(32)
            ->setTransferPlanAnticipated(true)
            ->setBankAccountBankNumber("001")
            ->setBankAccountNumber("31232156132-12")
            ->setBankAccountBranchNumber("0031")
            ->setBankAccountVariation("001")
            ->setBankAccountType("corrente")
            ->setBankAccountIsJuridic(true)
            ->setAddressCityCode("2800308")
            ->setAddressDistrict("Farolândia")
            ->setAddressLine1("Rua Silvio do Espírito Santos Seixas")
            ->setAddressLine2("Ap 001, Cleveland House")
            ->setAddressStreetNumber("92")
            ->setAddressZipCode("49030-423")
            ->setupHolderAccount();

        $this->assertTrue(true);
    }

    public function testShouldCreateAccount()
    {
        $paggcerto = new Paggcerto(new NoAuth());

        $cnpj = (new CnpjTool())->createCnpj(true);

        $account = $paggcerto
            ->account()
            ->setHolderFullName("Mariana Fulano de Tal")
            ->setHolderBirthDate("1995-01-18")
            ->setHolderGender("F")
            ->setHolderTaxDocument("927.228.895-95")
            ->setHolderPhone("(79) 2946-7954")
            ->setHolderMobile("(79) 99999-9999")
            ->setCompanyTradeName("Esportes ME")
            ->setCompanyFullName("Mariana e Emanuelly Esportes ME")
            ->setCompanyTaxDocument($cnpj)
            ->setBusinessTypeId("vL")
            ->setAddressCityCode("2800308")
            ->setAddressDistrict("Farolândia")
            ->setAddressLine1("Rua Silvio do Espírito Santos Seixas")
            ->setAddressLine2("Ap 001, Cleveland House")
            ->setAddressStreetNumber("92")
            ->setAddressZipCode("49030-423")
            ->setBankAccountBankNumber("001")
            ->setBankAccountNumber("31232156132-12")
            ->setBankAccountBranchNumber("0031")
            ->setBankAccountVariation("001")
            ->setBankAccountType("corrente")
            ->setBankAccountIsJuridic(true)
            ->setUserEmail("mariana@email" . rand(0,999999). ".com")
            ->setUserPassword("12345678")
            ->setBusinessActivityId("vL")
            ->setMarketingMediaId("b9")
            ->setTransferPlanDays(32)
            ->setTransferPlanAnticipated(true)
            ->createHolderAccount();

        $this->assertNotEmpty($account);
        $this->assertEquals("Mariana Fulano de Tal", $account->holder->fullName);
        $this->assertEquals("F", $account->holder->gender);
        $this->assertEquals("927.228.895-95", $account->holder->taxDocument);
        $this->assertEquals("(79) 2946-7954", $account->holder->phone);
        $this->assertEquals("(79) 99999-9999", $account->holder->mobile);
        $this->assertEquals(false, $account->holder->blacklist);
        $this->assertEquals("Esportes ME", $account->holder->company->tradeName);
        $this->assertEquals("Mariana e Emanuelly Esportes ME", $account->holder->company->fullName);
        $this->assertEquals($cnpj, $account->holder->company->taxDocument);
        $this->assertEquals("vL", $account->holder->company->businessType->id);
        $this->assertEquals("Sociedade Empresária Limitada", $account->holder->company->businessType->name);
        $this->assertEquals("vL", $account->businessActivity->id);
        $this->assertEquals("Farolândia", $account->address->district);
        $this->assertEquals("Rua Silvio do Espírito Santos Seixas", $account->address->line1);
        $this->assertEquals("Ap 001, Cleveland House", $account->address->line2);
        $this->assertEquals("92", $account->address->streetNumber);
        $this->assertEquals("49030-423", $account->address->zipCode);
        $this->assertEquals("Aracaju", $account->address->city->name);
        $this->assertEquals("2800308", $account->address->city->code);
        $this->assertEquals("001", $account->bankAccount->bankNumber);
        $this->assertEquals("Banco do Brasil S.A.", $account->bankAccount->bankName);
        $this->assertEquals("31232156132-12", $account->bankAccount->accountNumber);
        $this->assertEquals("0031", $account->bankAccount->bankBranchNumber);
        $this->assertEquals("001", $account->bankAccount->variation);
        $this->assertEquals("Corrente", $account->bankAccount->type);
        $this->assertEquals(32, $account->account->transferPlan->days);
        $this->assertEquals(true, $account->account->transferPlan->anticipated);
        $this->assertEquals(true, $account->bankAccount->isJuristic);
        $this->assertEquals(true, $account->account->active);
        $this->assertEquals(true, $account->account->approved);
        $this->assertEquals(true, $account->account->freeTrial);
        $this->assertEquals(false, $account->account->balanceBlocked);
        $this->assertEquals(false, $account->account->oldAnticipationPlan);
        $this->assertEquals(0, $account->account->vanBanese);
        $this->assertEquals("Esportes ME", $account->holder->company->tradeName);
        $this->assertEquals("MARIANAEEMANU", $account->account->softDescriptor);
        $this->assertEquals(null, $account->registrationOrigin->timeOnScreen);
        $this->assertEquals("Desktop", $account->registrationOrigin->device);
        $this->assertEquals("Generic", $account->registrationOrigin->browser);
        $this->assertEquals(null, $account->registrationOrigin->platform);
        $this->assertEquals(null, $account->registrationOrigin->engine);
        $this->assertEquals("b9", $account->registrationOrigin->marketingMedia->id);
        $this->assertEquals("Anúncio no Google", $account->registrationOrigin->marketingMedia->name);
    }

    public function testShouldGetSetupHolderAccountSandbox()
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));

        $presets = $paggcerto->account()->getSetupHolderAccount();

        $this->assertNotEmpty($presets);
        $this->assertEquals("Erick Antunes", $presets->holder->fullName);
        $this->assertEquals("M", $presets->holder->gender);
        $this->assertEquals("555.746.290-20", $presets->holder->taxDocument);
        $this->assertEquals("(79) 99999-9999", $presets->holder->mobile);
        $this->assertEquals("Universidade Life", $presets->holder->company->tradeName);
        $this->assertEquals("Nanitec operações limitadas", $presets->holder->company->fullName);
        $this->assertEquals("15.150.963/0001-49", $presets->holder->company->taxDocument);
        $this->assertEquals("Farolândia", $presets->address->district);
        $this->assertEquals("Rua Silvio do Espírito Santos Seixas", $presets->address->line1);
        $this->assertEquals("92", $presets->address->streetNumber);
        $this->assertEquals("49030-423", $presets->address->zipCode);
        $this->assertEquals("2800308", $presets->address->city->code);
        $this->assertEquals("Aracaju", $presets->address->city->name);
        $this->assertEquals("SE", $presets->address->city->state);
        $this->assertEquals("001", $presets->bankAccount->bankNumber);
        $this->assertEquals("Banco do Brasil S.A.", $presets->bankAccount->bankName);
        $this->assertEquals("31232156132-12", $presets->bankAccount->accountNumber);
        $this->assertEquals("0031", $presets->bankAccount->bankBranchNumber);
        $this->assertEquals("001", $presets->bankAccount->variation);
        $this->assertEquals("corrente", strtolower($presets->bankAccount->type));
        $this->assertEquals(true, $presets->bankAccount->isJuristic);
        $this->assertEquals(true, $presets->account->active);
        $this->assertEquals(true, $presets->account->approved);
        $this->assertEquals(true, $presets->account->freeTrial);
        $this->assertEquals(false, $presets->account->balanceBlocked);
        $this->assertEquals(false, $presets->account->oldAnticipationPlan);
        $this->assertEquals(0, $presets->account->vanBanese);
        $this->assertEquals("LIMIT", $presets->account->softDescriptor);
    }

    /**
     * @expectedExceptionCode 422
     * @expectedException  \Exception
     * @expectedExceptionMessage EXPIRED_HASH
     */
    public function testShouldOAuthExceptionWithHash()
    {
        try {
            $hash = "32YfLcObZAyCNFfbBWp1wYTB6OJx2tFoe1sd4YU2e26TlsBypf29DhXLBiGKjl60bJyKPFbdtvwUZ72Jta1soey48I-2VGy0" .
                "ple8ba7KSBHXv0fM56G_dBlv2ySyvIqXhN341jjaoQj9omvLt2r1VO-I6KosDAm-PZ6-GWiGGh0seuEp2G_Bjexj588Bmyq-";
            new Paggcerto(new AuthHash($hash));
        }
        catch (AuthException $e)
        {

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
