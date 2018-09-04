# Paggcerto SDK PHP v1 
![Home Image](https://cdn.paggcerto.com.br/img/git/paggcerto-developer.png)

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
        - [Consultar tipos de empresa](#consultar-tipos-de-empresa)
        - [Consultar cidades](#consultar-cidades)
        - [Consultar bancos](#consultar-bancos)
        - [Consultar ramo de atividade](#consultar-ramo-de-atividade)
        - [Consultar medias de marketing](#consultar-medias-de-marketing)
    - [Gerenciamento dos perfis de usuários](#gerenciamento-dos-perfis-de-usuários)
        - [Cadastrar perfil](#cadastrar-perfil)
        - [Atualizar perfil](#atualizar-perfil)
        - [Listar perfis](#listar-perfis)
            - [Sem filtros](#sem-filtros)
            - [Com filtros](#com-filtros)
        - [Pesquisar perfil](#pesquisar-perfil)
        - [Desativar perfil](#desativar-perfil)
        - [Ativar perfil](#ativar-perfil)
        - [Remover perfil](#remover-perfil)


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

$paggcerto = new Paggcerto(new NoAuth, $endpoint);
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
### Criar conta
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
- Escolher  o dia para repasse: 2 ou 32 dias;

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

### Obter configurações da conta
Neste método são exibidas todas as informações do titular da conta.

```php
$presets = $paggcerto->account()->getSetupHolderAccount();

print_r($presets);
```

## Métodos complementares
São métodos de consulta, que apresentam informações complementares para a criação da [conta titular](#criar-conta)

### Consultar tipos de empresa
Nesta consulta são retornados todos os tipos de empresa.

```php
$businessTypes = $paggcerto->businessType()->getRequest();

print_r($businessTypes);
```

### Consultar cidades
Com a utilização desta consulta são retornadas as informações a respeito das cidades que estão localizadas no estado informado no *endpoint*.

```php
$cities = $paggcerto->city()->getRequest(["SE"]);

print_r($cities);
```

 ### Consultar bancos
 É retornada uma lista com informações a respeito das instituições financeiras.

```php
$banks = $paggcerto->bank()->getRequest();

print_r($banks);
```

### Consultar ramo de atividade
Com a utilização desta consulta são retornadas as informações de todos os ramos de atividades.

```php
$businessActivities = $paggcerto->businessActivity()->getRequest();

print_r($businessActivities);
```

### Consultar medias de marketing
Ao utilizar esta consulta são retornadas as informações a respeito das medias de marketing, que possibilitaram o usuário conhecer a Paggcerto.

```php
$marketingMedias = $paggcerto->marketingMedia()->getRequest();

print_r($marketingMedias);
```

## Gerenciamento dos perfis de usuários
O titular da conta pode configurar perfis de usuários para que outras pessoas possam realizar operações na conta do titular. O perfil determina quais funcionalidades os usuários podem ter acesso. Abaixo estão os exemplos para o gerenciamento destes perfis.

### Cadastrar perfil

```php    
$createdRole = $paggcerto->role()
    ->setName("Administrador")
    ->createRole();

print_r($createdRole);
```
### Atualizar perfil
Para atualizar o perfil é necessário informado o identificador  único `roleId` do perfil desejado.
```php
$updatedRole = $paggcerto->role()
    ->setName("Admin Update Test")
    ->setActive(true)
    ->setRoleId("a0b1")
    ->updateRole();

print_r($updatedRole);
```

### Listar perfis

#### Sem filtros

```php
$list = $paggcerto->role()
    ->rolesList();

print_r($list);
```

#### Com filtros

```php
$listWithFilters = $paggcerto->role()
    ->setLength(2)
    ->setIndex(2)
    ->rolesList();

print_r($listWithFilters);
```

### Pesquisar perfil
Este método é utilizado quando se deseja buscar um perfil específico, para isso o `roleId` do perfil deve ser informado. 

```php
$search = $paggcerto->role()
    ->setRoleId("a0b1")
    ->searchRole();

print_r($search);
```

### Desativar perfil
O `roleId` deve ser informado para desativar o perfil. 

```php
 $deactivate = $paggcerto->role()
    ->setRoleId("a0b1")
    ->deactivateRole();

print_r($deactivate);
```

### Ativar perfil
Informar o `roleId` para ativar o perfil. 
```php
$activate = $paggcerto->role()
    ->setRoleId("a0b1")
    ->activateRole();

print_r($activate);
```

### Remover perfil
Para remover um perfil deve ser informado o `roleId`.

```php
$delete = $paggcerto->role()
    ->setRoleId("a0b1")
    ->deleteRole();

print_r($delete);
``` 


