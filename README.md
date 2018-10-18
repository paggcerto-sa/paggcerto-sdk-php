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
    - [Autenticação](#autenticação)
        - [Autenticar com credenciais](#autenticar-com-credenciais)
        - [Autenticar com hash](#autenticar-com-hash)
        - [Sem autenticação](#sem-autenticação)
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
    - [Permissões dos perfis](#permissões-dos-perfis)
        - [Conceder permissão](#conceder-permissão)
        - [Revogar permissão](#revogar-permissão)
    - [Gerenciamento dos usuário](#gerenciamento-dos-usuários)
        - [Cadastrar usuário](#cadastrar-usuário)
        - [Atualizar usuário](#atualizar-usuário)


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
São métodos de consulta, que apresentam informações complementares para a criação da [conta titular](#criar-conta). Para acessar estes métodos não precisam estar [autenticado](#sem-autenticação).

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

## Autenticação
O primeiro passo após a realização do cadastro da conta do titular é realizar sua autenticação. Nesta etapa será gerado o token de acesso para se conectar com nosso SDK e assim realizar as requisições. O token de acesso é confidencial e recomendamos não compartilhá-lo em ambientes públicos ou com terceiros. A seguir estão descritos os métodos que são responsáveis pela autenticação.

### Autenticar com credenciais
O objetivo da autenticação do usuário é ter como resultado a geração do Token de Acesso. O token gerado para o ambiente sandbox é diferente do token do ambiente de produção.

```php
$paggcerto = new Paggcerto(new Auth("mariana@email.com", "12345678"));
```
### Autenticar com hash
A finalidade deste método é realizar a autenticação do usuário que foi cadastrado pelo titular da conta através do Hash que foi enviado ao e-mail desse usuário. Como resultado, é gerado o token temporário, que deve ser utilizado para Criar Nova Senha.

```php
$paggcerto = new Paggcerto(new AuthHash("ZAyCNFfbBWp1wYTB6OJx2e1sd45156d4fewfcdsvcd454"));
```

### Sem autenticação
Para acessar os [métodos complementares](#métodos-complementares) não é necessário estar autenticado. Abaixo está o exemplo:

```php
$paggcerto = new Paggcerto(new NoAuth());
```

## Gerenciamento dos perfis de usuários
O titular da conta pode configurar perfis de usuários para que outras pessoas possam realizar operações na conta do titular. O perfil determina quais funcionalidades (métodos ou recursos) os usuários podem ter acesso. Abaixo estão os exemplos para o gerenciamento destes perfis.

### Cadastrar perfil

```php    
$createdRole = $paggcerto->role()
    ->setName("Administrador")
    ->createRole();

print_r($createdRole);
```
### Atualizar perfil
Para atualizar o perfil é necessário informar o identificador  único `roleId` do perfil desejado.
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
## Permissões dos perfis
Para que o usuário acesse as funcionalidades é necessário que ele esteja vinculado à um perfil e que este perfil tenha as devidas permissões. 

### Conceder permissão
Para conceder as permissões é necessário informar o `roleId`.

```php
$paggcerto->roleConcept()
    ->setRoleId("a0b1")
    ->setScopes(["account.users.edit", "account.users.readonly"])
    ->roleGrantPermission();
```
### Revogar permissão
O `roleId` deve ser informado para remover a permissão.

```php
$paggcerto->roleConcept()
    ->setRoleId("a0b1")
    ->setScopes(["account.users.edit", "account.users.readonly"])
    ->roleRevokePermission();
```
## Gerenciamento dos usuários
A seguir serão apresentados todos os métodos com funcionalidades para o gerenciamento dos usuários. Os usuários são pessoas que realizam operações em uma conta com a permissão do titular, é necessário que o usuário esteja associado a um perfil.

### Cadastrar usuário
Com a utilização deste método um novo usuário é criado. Os usuários recém-criados receberão por e-mail o hash de autenticação, que será utilizado no método [autenticar com Hash](#autenticar-com-hash).

Para acessar esse método é necessário ter a seguinte permissão: **account.users.edit**

```php    
$createdUser = $paggcerto->user()
    ->setRoleId("a0b1")
    ->setFullName("João Mateus dos Santos")
    ->setEmail("joao@email.com")
    ->setTaxDocument("123.123.123-87")
    ->setAppUrl("http://meuaplicativo.com.br")
    ->createUser();

print_r($createdUser);
```
### Atualizar usuário
Com a utilização deste método os dados do usuário serão atualizados, para isso é necessário informar o `id` do usuário desejado. 

Para ter acesso a esse método, é necessário ter a seguinte permissão: **account.users.edit**.

```php
$updatedUser = $paggcerto->user()
    ->setId("d2e2")
    ->setRoleId("a0b1")
    ->setFullName("João Mateus dos Santos")
    ->setEmail("joao@email.com")
    ->setTaxDocument("123.123.123-87")
    ->updateUser();

print_r($updatedUser);
```