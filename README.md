<img width="" src="icon.png" align="right" />

# Paggcerto v1 PHP client SDK 
> O modo mais simples e fácil de integrar sua aplicação PHP com a Paggcerto.

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/3ff8c94e1b40460e8ad901f4703e1d33)](https://www.codacy.com/app/erickants/paggcerto-sdk-php?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=paggcerto-sa/paggcerto-sdk-php&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/3ff8c94e1b40460e8ad901f4703e1d33)](https://www.codacy.com/app/erickants/paggcerto-sdk-php?utm_source=github.com&utm_medium=referral&utm_content=paggcerto-sa/paggcerto-sdk-php&utm_campaign=Badge_Coverage)
[![Build Status](http://jenkins.heaphost.com/buildStatus/icon?job=Paggcerto%20SDK-PHP)](http://jenkins.heaphost.com/job/Paggcerto%20SDK-PHP)

---

**Sumário**

- [Requisições](#requisições)
- [Instalação](#instalação)
    - [Configurando a instalação](#configurando-a-instalação)
        - [Sem auth](#sem-auth)
        - [Por auth com credenciais](#por-auth-com-credenciais)
        - [Por auth com hash](#por-auth-com-hash)
- [Exemplos de utilização](#conta-do-titular)
    - [Conta do Titular](#conta-do-titular)
        - [Criar conta](#criar-conta)
        - [Configurar conta](#configurar-conta)
        - [Obter conta](#obter-conta)
    - [Métodos complementares](#métodos-complementares)

## Requisições
Para utilizar nosso SDK é necessário ter as seguintes requisições:

#### require
* PHP >= 5.5
* rmccue/requests >= 1.0

#### require-dev
* phpunit/phpunit ~ 5.0

## Instalação

Para iniciar a instalação execute em seu shell:

```php
composer require paggcerto/paggcerto-sdk-php
```

### Configurando a instalação
#### Sem auth

```php
require 'vendor/autoload.php';

use Paggcerto\Auth;
use Paggcerto\Auth\NoAuth;

$endpoint = "prod";

$paggcerto = new Paggcerto(new NAuth, $endpoint);
```
#### Por auth com credenciais

```php
require 'vendor/autoload.php';

use Paggcerto\Auth;
use Paggcerto\Auth\Auth;

$endpoint = "prod";
$user = "example@email.com";
$password = "12345678";

$paggcerto = new Paggcerto(new Auth($user, $password), $endpoint);
```
#### Por auth com hash

```php
require 'vendor/autoload.php';

use Paggcerto\Auth;
use Paggcerto\Auth\Auth;

$endpoint = "prod";
$hash = "Ehjikkja585569779efwrf.ihuheyvvc872622791ndbdehv";

$paggcerto = new Paggcerto(new AuthHash($hash), $endpoint);
```
## Exemplos de utilização

## Conta do Titular
### Cria conta
Este método é utilizado para o cadastro da conta do titular. Após a finalização deste cadastro, deve ser realizada a autenticação do titular da conta.
```php
$holder = $paggcerto->account()
    ->setHolderFullName("Mariana Fulano de Tal")
    ->setHolderBirthDate("1995-01-18")
    ->setHolderGender("F")
    ->setHolderTaxDocument("927.228.895-95")
    ->setHolderPhone("(79) 2946-7954")
    ->setHolderMobile("(79) 99999-9999")
    ->setCompanyTradeName("Esportes ME")
    ->setCompanyFullName("Mariana e Emanuelly Esportes ME")
    ->setCompanyTaxDocument("94.467.995/0001-49")
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
    ->setUserEmail("mariana@email.com")
    ->setUserPassword("12345678")
    ->setBusinessActivityId("MA")
    ->setMarketingMediaId("k5")
    ->setTransferPlanDays(32)
    ->setTransferPlanAnticipated(true)
    ->createHolderAccount();

print_r($holder);
```
### Configurar conta
Com a configuração da conta podem ser alteradas as seguintes informações:
- Conta bancária;
- A descrição que irá constar na fatura do cliente                    ;
- Endereço;
- Escoher o dia para repasse: 2 ou 32 dias;

```php
$presetsHolder = $paggcerto->account()
    ->setUserPassword("12345678")
    ->setPhone("(79) 2946-7954")
    ->setMobile("(79) 99999-9999")
    ->setComercialName("Esporte e CIA")
    ->setSoftDescriptor("Esportes ME")
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
```

### Obter conta
Neste método são exibidas todas as informações do titular da conta.

```php
$presets = $paggcerto->account()->getSetupHolderAccount();

print_r($presets);
```
