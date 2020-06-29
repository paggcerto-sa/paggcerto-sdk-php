<?php
/**
 * User: marcus.vinicius
 * Date: 29/08/2018
 * Time: 16:52
 */

namespace Paggcerto\Tests;


use Paggcerto\Auth\Auth;
use Paggcerto\Helper\CpfTool;
use Paggcerto\Paggcerto;

class SplitTest extends TestCase
{

    public function testShouldCreateSplit()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $cpf = (new CpfTool())->create(true);

        $createSplit = $paggcerto->split()
            ->setName("Administrador")
			->setHolderName("Mariana Fulano de Tal")
			->setTaxDocument($cpf)
			->setAddressCityCode("2800308")
			->setAddressDistrict("Smallville")
			->setAddressLine1("Rua do Talon")
			->setAddressLine2("Ap 001, Cleveland House")
			->setAddressStreetNumber("6000")
			->setAddressZipCode("49030-620")
			->setBankAccountBankNumber("001")
			->setBankAccountNumber("31232156132-12")
			->setBankAccountBranchNumber("0031")
			->setBankAccountType("corrente")
			->setTransferDays(32)
			->setAnticipatedTransfer(true)
            ->createSplitter();

        $this->assertNotEmpty($createSplit->id);
        $this->assertEquals("Administrador", $createSplit->name);
		$this->assertEquals($cpf, $createSplit->bankAccount->taxDocument);
		$this->assertEquals("Smallville", $createSplit->address->district);
		$this->assertEquals("Rua do Talon", $createSplit->address->line1);
		$this->assertEquals("Ap 001, Cleveland House", $createSplit->address->line2);
		$this->assertEquals("6000", $createSplit->address->streetNumber);
		$this->assertEquals("49030-620", $createSplit->address->zipCode);
		$this->assertEquals("2800308", $createSplit->address->cityCode);
		$this->assertEquals("001", $createSplit->bankAccount->bankNumber);
		$this->assertEquals("31232156132-12", $createSplit->bankAccount->accountNumber);
		$this->assertEquals("0031", $createSplit->bankAccount->bankBranchNumber);
		$this->assertEquals("Corrente", $createSplit->bankAccount->type);
		$this->assertEquals(32, $createSplit->transferDays);
		$this->assertEquals(true, $createSplit->anticipatedTransfer);

        return $createSplit->id;
    }

	/**
	 * @depends testShouldCreateSplit
	 * @throws \Exception
	 */
    public function testShouldUpdateSplit($id)
    {

        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();
        $cpf = (new CpfTool())->create(true);

		$updateSplit = $paggcerto->split()
			->setSplitterId($id)
			->setName("Administrado")
			->setHolderName("Mariana Fulano de Tal")
			->setTaxDocument($cpf)
			->setAddressCityCode("2800308")
			->setAddressDistrict("Smallville")
			->setAddressLine1("Rua do Talon")
			->setAddressLine2("Ap 001, Cleveland House")
			->setAddressStreetNumber("6000")
			->setAddressZipCode("49030-620")
			->setBankAccountBankNumber("001")
			->setBankAccountNumber("31232156132-12")
			->setBankAccountBranchNumber("0031")
			->setBankAccountType("corrente")
			->setTransferDays(32)
			->setAnticipatedTransfer(false)
			->updateSplitter();

		$this->assertNotEmpty($updateSplit->id);
		$this->assertEquals("Administrado", $updateSplit->name);
		$this->assertEquals($cpf, $updateSplit->bankAccount->taxDocument);
		$this->assertEquals("Smallville", $updateSplit->address->district);
		$this->assertEquals("Rua do Talon", $updateSplit->address->line1);
		$this->assertEquals("Ap 001, Cleveland House", $updateSplit->address->line2);
		$this->assertEquals("6000", $updateSplit->address->streetNumber);
		$this->assertEquals("49030-620", $updateSplit->address->zipCode);
		$this->assertEquals("2800308", $updateSplit->address->cityCode);
		$this->assertEquals("001", $updateSplit->bankAccount->bankNumber);
		$this->assertEquals("31232156132-12", $updateSplit->bankAccount->accountNumber);
		$this->assertEquals("0031", $updateSplit->bankAccount->bankBranchNumber);
		$this->assertEquals("Corrente", $updateSplit->bankAccount->type);
		$this->assertEquals(32, $updateSplit->transferDays);
		$this->assertEquals(true, $updateSplit->anticipatedTransfer);
    }

	/**
	 * @depends testShouldCreateSplit
	 * @throws \Exception
	 */
    public function testShouldSearchSplit($id)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $return = $paggcerto->split()
            ->setSplitterId($id)
            ->searchSplitter();

        $this->assertNotEmpty($return);
    }
}