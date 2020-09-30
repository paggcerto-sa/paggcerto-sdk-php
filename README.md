# Paggcerto SDK PHP v1.1.7
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
        - [Autenticar com id do lojista a partir do parceiro](#autenticar-com-id-do-lojista-a-partir-do-parceiro)
    - [Gerenciamento dos perfis de usuários](#gerenciamento-dos-perfis-de-usuários)
        - [Cadastrar perfil](#cadastrar-perfil)
        - [Atualizar perfil](#atualizar-perfil)
        - [Listar perfis](#listar-perfis)
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
        - [Listar usuários](#listar-usuários)
        - [Pesquisar usuário](#pesquisar-usuário)
        - [Desativar usuário](#desativar-usuário)
        - [Ativar usuário](#ativar-usuário)
    - [Pagamentos](#pagamentos)
    - [Pagamento com cartão](#pagamento-com-cartão)
        - [Consultar bandeiras](#consultar-bandeiras)
        - [Simular pagamento](#simular-pagamento)
        - [Efetuar pagamento com cartão](#efetuar-pagamento-com-cartão)
        - [Pagamento com pré-captura](#pagamento-com-pré-captura)
        - [Continuar pagamento](#continuar-pagamento)
        - [Capturar pagamento](#capturar-pagamento)
        - [Enviar comprovante](#enviar-comprovante)
    - [Pagamento com boleto](#pagamento-com-boleto)
        - [Efetuar pagamento com boleto](#efetuar-pagamento-com-boleto)
    - [Conclusão do pagamento](#conclusão-do-pagamento)
        - [Finalizar pagamento](#finalizar-pagamento)
    - [Cancelamento](#cancelamento)
        - [Cancelar pagamento](#cancelar-pagamento)
        - [Cancelar transação do cartão](#cancelar-transação-do-cartão)
    - [Relatórios](#relatórios)
        - [Detalhes do pagamento](#detalhes-do-pagamento)
    - [Gerenciamento dos recebedores](#gerenciamento-dos-recebedores)
        - [Cadastrar recebedor](#cadastrar-recebedor)
        - [Atualizar recebedor](#atualizar-recebedor)
        - [Listar recebedores](#listar-recebedores)
        - [Pesquisar recebedor](#pesquisar-recebedor)


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
$appId = "LkD";

$paggcerto = new Paggcerto(new Auth($user, $password, $appId), $endpoint);
```
#### Por auth com hash

```php
require 'vendor/autoload.php';

use Paggcerto\Auth;
use Paggcerto\Auth\Auth;

$endpoint = "prod";
$hash = "Ehjikkja585569779efwrf.ihuheyvvc872622791ndbdehv";
$appId = "LkD";

$paggcerto = new Paggcerto(new AuthHash($hash, $appId), $endpoint);
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
    ->setMothersName("Mothers Name")
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
    ->setMothersName("Mothers Name")
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
$paggcerto = new Paggcerto(new Auth("mariana@email.com", "12345678", "applicationId"));
```
### Autenticar com hash
A finalidade deste método é realizar a autenticação do usuário que foi cadastrado pelo titular da conta através do Hash que foi enviado ao e-mail desse usuário. Como resultado, é gerado o token temporário, que deve ser utilizado para Criar Nova Senha.

```php
$paggcerto = new Paggcerto(new AuthHash("ZAyCNFfbBWp1wYTB6OJx2e1sd45156d4fewfcdsvcd454"));
```

### Autenticar com id do lojista a partir do parceiro
Através deste método, o parceiro gera o token para o lojista sem a necessidade de conhecer a sua senha, passando apenas o id do lojista que se deseja gerar o token.

```php
$paggcerto = new Paggcerto(new AuthHashByPartner("holderId"));
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
Com a utilização deste método os dados do usuário serão atualizados, para isso é necessário informar o `ID` do usuário desejado. 

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

### Listar usuários
O objetivo deste método é listar todos os usuários cadastrados.

Para ter acesso a esse método, é necessário ter a seguinte permissão: **account.users.readonly**

#### Sem filtros

```php
$list = $paggcerto->user()
    ->usersList();

print_r($list);
```

#### Com filtros

```php
$listWithFilters = $paggcerto->user()
    ->setFullName("João Mateus")
    ->setEmail("joao@email.com")
    ->setTaxDocument("123.123.123-87")
    ->setLength(2)
    ->setIndex(2)
    ->usersList();

print_r($listWithFilters);
```
### Pesquisar usuário
Esse método deve ser utilizado quando se deseja pesquisar um usuário específico, para isso o `ID` do usuário deve ser informado. 

Para ter acesso a esse método, é necessário ter a seguinte permissão: **account.users.readonly**

```php
$search = $paggcerto->user()
    ->setId("d2e2")
    ->searchUser();

print_r($search);
```

### Desativar usuário
O `ID` deve ser informado para desativar o usuário. 

Para ter acesso a esse método, é necessário ter a seguinte permissão: **account.users.edit**

```php
 $deactivate = $paggcerto->user()
    ->setId("d2e2")
    ->deactivateUser();

print_r($deactivate);
```

### Ativar usuário
Informar o `ID` para ativar o usuário. 

Para ter acesso a esse método, é necessário ter a seguinte permissão: **account.users.edit**
```php
$activate = $paggcerto->user()
    ->setId("d2e2")
    ->activateUser();

print_r($activate);
```
## Pagamentos

## Pagamento com cartão
Pagamento com cartão pode ser realizado a vista ou parcelado, utilizando múltiplos cartões e com possibilidade de split de pagamento. Cada transação de cartão deve obedecer requisitos pré-determinados: validade, limite financeiro do cartão, nome do titular do cartão e código de segurança. Nesta seção são exibidos os métodos para sua utilização.

A tabela abaixo apresenta alguns cartões para a realização de testes em nosso ambiente sandbox. Neste ambiente o nome do titular, a data de validade e o cvv podem ser fictícios:

 Bandeira| Nº do cartão
 :--------|:---------
 AMEX | 349881342411264 
 DINERSCLUB | 30386724055675
 ELO | 6363693078504487 
 HIPERCARD | 6062820640453968
 MASTERCARD | 5111925270937702
 VISA | 4929915748910899

 ### Consultar bandeiras
 Esse método retorna uma lista com todas as bandeiras aceitas pela Paggcerto e suas respectivas regras de processamento (expressões regulares).

```php
$result = $paggcerto->cardPayment()
   ->getCardsBrands();

print_r($result->bins());
```
 ### Simular pagamento
Ao utilizar este método é calculado o valor que o titular irá receber de acordo com o valor cobrado para um pagamento com cartão.

```php
$result = $paggcerto->cardPayment()
    ->setAmount(100)
    ->setInstallments(2)
    ->setCardBrand("visa")
    ->setCredit(true)
    ->setCustomerPaysFee(true)
    ->setPinpad(false)
    ->paySimulate();

print_r($result);
```

### Efetuar pagamento com cartão
Esse método permite que o usuário realize um pagamento utilizando um ou mais cartões. Quando o valor do pagamento não for atingido, ele pode ser continuado com novos cartões através do método [Continuar Pagamento](#continuar-pagamento).

Em `addCard` devem ser inseridas as seguintes informações: Nome do titular impreso no cartão, número do cartão, mês da validade, ano da validade, valor cobrado (esse valor não pode ser inferior a R$ 1,00 para venda à vista ou inferior a R$ 5,00 para venda parcelada), CVV, número da parcelas, informar  a modalidade da venda: credito (`true`) ou débito (`false`). 

Para ter acesso a esse método, é necessário ter a seguinte permissão: **payments.create**.

```php
$result = $paggcerto->cardPayment()
    ->setAmount(158.35)
    ->addCard("Rodrigo Alves", "5111925270937702", 12, 2018, 158.35, "035", 1, true)
    ->setPaymentDeviceSerialNumber("8000151509001953")
    ->setPaymentDeviceModel("mp5")
    ->pay();

print_r($result);
```

### Pagamento com pré-captura
Com a utilização desse método o usuário poderá realizar um pagamento pré-autorizado, ou seja, a autorização do pagamento será realizada de forma manual através do método [Capturar Pagamento](#capturar-pagamento). Sendo assim, o valor informado será temporariamente bloqueado no cartão até que seja finalizada a autorização do pagamento. Para esse tipo de pagamento, o campo **isAuthorizedSale** estar com o valor **true** e deve ser informado a quantidade de dias limite para a captura do pagamento no campo **setDaysLimitAuthorization**. Se este campo não for informado e o *isAuthorizedSale* for *true*, será considerado a quantidade de 29 dias.

Para ter acesso a esse método, é necessário ter a seguinte permissão: **payments.create**.

```php
$result = $paggcerto->cardPayment()
    ->setAmount(158.35)
    ->addCard("Rodrigo Alves", "5111925270937702", 12, 2018, 158.35, "035", 1, true)
    ->setPaymentDeviceSerialNumber("8000151509001953")
    ->setPaymentDeviceModel("mp5")
    ->isAuthorizedSale(true)
    ->setDaysLimitAuthorization(28)
    ->pay();

print_r($result);
```

### Continuar pagamento
A finalidade desse método é permitir que o usuário continue o pagamento que não foi finalizado (o valor do pagamento não foi atingido).

Para ter acesso a esse método, é necessário ter a seguinte permissão: **payments.create**.

```php
 $result = $paggcerto->cardPayment()
    ->setPaymentId($payment->id)
    ->addCard("Maria Alves", "6363693078504487", 5, 2020, 50, "587", 1, false)
    ->payContinue();

print_r($result);
```

### Capturar pagamento 

O objetivo desse método é permitir a captura manual de um pagamento em duas etapas:

- O campo **isAuthorizedSale** do método [Pagamento com pré-captura](#pagamento-com-pré-captura) deve ser igual a **true**.
- Utilizar esse método para a captura efetiva do pagamento.

**Somente o titular possui acesso a esse método.**

```php
$result = $paggcerto->cardPayment()
    ->setPaymentId($payment->id)
    ->setAmount(158.35)
    ->paymentCapture();

print_r($result);
```

### Enviar Comprovante
O objetivo deste método é enviar o comprovante da transação para o cliente.

Para ter acesso a esse método, é necessário ter a seguinte permissão: **payments.create**.

```php
$receipt = $paggcerto->cardPayment()
    ->setNsu("1005")
    ->setEmail("alves@email.com")
    ->sendReceipt();
```
## Pagamento com boleto
Boleto é um título de cobrança que pode ser pago em qualquer instituição ou estabelecimento conveniado. Além de indicar a data de vencimento, podem conter informações sobre desconto e/ou acréscimo de multa e juros e outras instruções. Após a emissão do boleto e se o e-mail e/ou telefone celular do pagador for informado ele poderá receber notificações, essas notificações são enviadas a partir das 11 horas de acordo com o horário de Brasília.

A tabela a seguir apresenta as regras para o envio das notificações:

Notificação | Regras | Comunicação 
 |--------|---------|----------
 Boleto à vencer | A notificação é enviada 3 dias antes do dia do vencimento ou no mesmo dia da emissão, caso o boleto seja emitido em até 3 dias antes do vencimento | Do titular para o pagador
 Boleto vencido | A notificação é enviada 1, 5 e 10 dias após vencimento | Do titular para o pagador
 Boleto pago | A notificação é enviada no mesmo dia da liquidação do boleto (após o processamento do arquivo de retorno enviado pelo banco) | Do titular para o pagador
 Boleto cancelado | A notificação é enviada no mesmo dia do cancelamento do boleto | Do titular para o pagador
 Boleto expirado | A notificação é enviada na data do cancelamento (baixa automática) programada junto ao banco no momento do registro | Do titular para o pagador 

 ### Efetuar pagamento com boleto
O ojetivo deste método é realizado o pagamento com boletos. Por meio dele pode ser gerado apenas um ou mais boletos (carnê).

Para ter acesso a esse método, é necessário ter a seguinte permissão: payments.create

```php
$dateDue = (new DateTime())->add(new DateInterval("P10D"));
$result = $paggcerto->bankSlipPayment()
    ->setDiscount(2.55)
    ->setDiscountDays(30)
    ->setFines(5)
    ->setInterest(3)
    ->setAcceptedUntil(15)
    ->addPayer("Rodrigo Alves", "953.262.300-03")
    ->addInstallment($dateDue->format("Y-m-d"), 100)
    ->setInstructions("PHP SDK")
    ->setNote("Descrição")
    ->pay();

print_r($result);
```

## Conclusão do pagamento

### Finalizar pagamento
Um pagamento é automaticamente finalizado quando a soma dos valores pagos atinge o valor esperado para o pagamento. Porém, também é possível finalizar um pagamento sem que a soma de todas as transações ou boletos pagos atingam o valor esperado para esse pagamento devido a:

    Pagamentos podem ser concluídos utilizando outra forma de pagamento (dinheiro, cheque, entre outros);

    A contratação do serviço pode ser cancelada, dessa forma os boletos futuros podem ser cancelados, porém, mantendo o que já foi pago.

Para ter acesso a esse método, é necessário ter a seguinte permissão: **payments.create**.

```php
$conclusion = $paggcerto->payment()
    ->setPaymentId("a0b1")
    ->setNote("O valor de R$ 50,00 foi pago em dinheiro.")
    ->payFinalize();

print_r($conclusion);
```

## Cancelamento

### Cancelar pagamento
O cancelamento somente será efetuado se for possível cancelar todas as transações com cartão e todos os boletos. Transações com cartão somente podem ser canceladas se forem realizadas na mesma data do seu processamento. Boletos podem ser cancelados desde que estejam pendentes ou vencidos, desta forma, não é possível cancelar boletos que já foram pagos.

Para ter acesso a esse método, é necessário ter a seguinte permissão: **payments.create**.

```php
$result = $paggcerto->payment()
    ->setPaymentId("a0b1")
    ->paymentCancel();

print_r($result);
```

### Cancelar transação do cartão
O cancelamento da transação do cartão somente será efetuado se for realizado na mesma data do seu processamento.

Para ter acesso a esse método, é necessário ter a seguinte permissão: **payments.create**.

```php
 $result = $paggcerto->cardPayment()
    ->setNsu("1005")
    ->cardTransactionCancel();

print_r($result);
```
### Cancelar boleto
O cancelamento do boleto somente será efetuado se seu pagamento estiver **pendente**.

Para ter acesso a esse método, é necessário ter a seguinte permissão: **payments.create**.

```php
 $result = $paggcerto->bankSlipPayment()
    ->setNumber("10000002345")
    ->cancel();

print_r($result);
```

## Relatórios

### Detalhes do pagamento
Este método deve ser utilizado para exibir todas as informações a respeito do pagamento desejado.

Para ter acesso a esse método, é necessário ter a seguinte permissão: **payments.readonly**

```php
 $result = $paggcerto->reportsManagement()
    ->setPaymentId($payment->id)
    ->getPaymentDetails();

print_r($result);
```

## Gerenciar os recebedores

### Cadastrar recebedor
A finalidade deste método é cadastrar os recebedores para split de pagamento. Somente o titular da conta pode cadastrar recebedores.

```php
    $createSplit = $paggcerto->split()
        ->setName("Administrador")
        ->setHolderName("Mariana Fulano de Tal")
        ->setTaxDocument("578.585.110-50")
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

    print_r($createSplit);
```

### Atualizar recebedor
O objetivo deste método é atualizar as informações do recebedor especificado no endpoint. Somente o titular da conta pode atualizar recebedores.

```php
    $updateSplit = $paggcerto->split()
        ->setSplitterId($id)
        ->setName("Administrado")
        ->setHolderName("Mariana Fulano de Tal")
        ->setTaxDocument("029.378.350-07")
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

    print_r($updateSplit);
```

### Pesquisar  recebedor
Esse método deve ser utilizado quando se deseja pesquisar um recebedor específico. Somente o titular da conta pode pesquisar recebedor.

```php
    $split = $paggcerto->split()
        ->setSplitterId($id)
        ->searchSplitter();

    print_r($split);
```

### Listar  recebedores
O objetivo deste método é listar todos os recebedores cadastrados. Somente o titular da conta pode listar recebedores.

```php
    $split = $paggcerto->split()
        ->setName("Fulano")
        ->splittersList();

    print_r($split);
```
