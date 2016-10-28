<p align="center">
  <a href="http://www.catho.com.br">
      <img src="http://static.catho.com.br/svg/site/logoCathoB2c.svg" alt="Catho"/>
  </a>
</p>
# backend-test

Uma pessoa esta a procura de emprego e dentre as várias vagas que existem no mercado (disponibilizadas nesse <a href="https://github.com/catho/backend-test/blob/master/vagas.json">JSON</a>) e ela quer encontrar vagas que estejam de acordo com o que ela saiba fazer, seja direto pelo cargo ou atribuições que podem ser encontradas na descrição das vagas. Para atender essa necessidade precisamos:

- uma API simples p/ procurar vagas (um GET p/ procurar as vagas no .json disponibilizado);
- deve ser possível procurar vagas por texto (no atributos title e description);
- deve ser possível procurar vagas por uma cidade;
- deve ser possível ordenar o resultado pelo salário (asc e desc);

O teste deve ser feito utilizando PHP (com ou sem framework, a escolha é sua). Esperamos como retorno, fora o GET da API funcionando, os seguintes itens:

- uma explicação do que é necessário para fazer seu projeto funcionar;
- como executar os testes, se forem testes de unidade melhor ainda;
- comentários nos códigos para nos explicar o que está sendo feito.

Lembre-se que na hora da avaliação olharemos para:

- organização de código;
- desempenho;
- manutenabilidade.

<hr>

### Instalando
```
git clone https://github.com/edugalb/backend-test.git
cd backend-test
composer install
```

### Rodando a aplicação
```
php -S localhost:8000 -t web
```

### Rodando os testes
```
phpunit
```
CodeCoverage: 100%
![Code Coverage](https://raw.githubusercontent.com/edugalb/backend-test/master/docs/coverage2.jpg)

### Endpoints
###### Retorna uma listagem de todas as vagas
```php
localhost:8000/api/v1/vagas
```
###### Retorna uma listagem aplicando o filtro no title
```php
localhost:8000/api/v1/vagas?title=Filtro no titulo
```

###### Retorna uma listagem aplicando o filtro no description
```php
localhost:8000/api/v1/vagas?description=Descricao
```
###### Retorna uma listagem aplicando o filtro na cidade
```php
localhost:8000/api/v1/vagas?cidade=Cidade Escolhida
```

###### Retorna uma listagem aplicando vários filtros
```php
localhost:8000/api/v1/vagas?title=Filtro no titulo&cidade=Cidade Escolhida&description=Descricao
```

###### Retorna uma listagem ordenando pelo salário ASC
```php
localhost:8000/api/v1/vagas?field=salario&order=asc
```
###### Retorna uma listagem ordenando pelo salário DESC
```php
localhost:8000/api/v1/vagas?field=salario&order=desc
```

###### Retorna uma listagem aplicando filtros e ordenando pelo salário DESC
```php
localhost:8000/api/v1/vagas?title=recepcionista&field=salario&order=desc
```
###### Parametros da query
```
'title' => 'max_len,255',
'description' => 'max_len,255',
'cidade' => 'max_len,50',
'field' => 'max_len,10',
'order' => 'contains,asc desc',
```

###### Response Sucess
```
http-code: 200
content-type: application/json
body:
{
  status: 1,
  alerta: "Listagem realizada com sucesso"
  data: [Json com elementos listados]
}
```

###### Response Error
```
http-code: 400
content-type: application/json
body:
{
  status: 0,
  alerta: "Erro ao validar o campo order"
  data: []
}
```


# Arquitetura
### Visão Geral
 -- Diagrama Elementos --
 
### Front-Controller
```php
$app->get( 'api/v1/vagas', function (Request $request) use ($app) {
    $ctrl = new App\Vagas\Controller\VagasController($app);
    return $ctrl->listVagas($request);
});
```
Sua única responsabilidade é acionar o controller correspondente a rota especificada, o parametro ```Request $request``` é injetado automáticamente pelo silex e corresponde a requisição HTTP que foi realizada

### Controller

##### Construção
```php
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
```
O controller é construído passando o Container do Silex ```Application $app```. Esta abordagem torna as classes mais flexíveis em caso de alteração de framework, portanto ao invés de Extender o Controller do silex e utilizar o método Connect eu preferi injetar direto o application

##### Método acionado
```php
public function listVagas(Request $request)
{
    // Construindo o Response
    $response = $this->app['ResponseFactory']->create();
    // Delegando a responsabilidade para o service
    try {
        $data = $this->app['vagas.service']->loadData($request->query->all());
    } catch (\Exception $e) {
        return $response->makeWithException($e);
    }
    // Retornando o Response
    return $response->makeWithSuccess($data, 'Listagem realizada com sucesso');
    }
```
No caso acima eu preferi manter o controller "Magro" sem regras de negócio, sua única responsabilidade é trabalhar com o ```Request $request``` e ```Response $response```. Sendo assim ele utiliza uma factory para criar o response (Irei falar mais adiante sobre factories) e delega o processamento para o ```VagasService``` que irá conter toda regra de negócio. Esta abordagem ajuda na criação dos testes unitários para o controller

## Services
```php
public function loadData(array $query)
{
    // Fabricando o DataMapper
    $dm = $this->app['DataMapperFactory']->create('vagas');
    
    // Validando e Filtrando os dados de input
    $validatedQuery = VagasValidator::validate($query);

    // Acionando o DataMapper passando os filtros e a ordenação
    return $dm->loadWithParams(
        VagasValidator::getFiltersFromQuery($validatedQuery),
        VagasValidator::getOrderFromQuery($validatedQuery)
    );
}
```
O service utiliza a factory para criar o ```VagasDataMapper```, realiza a validação dos dados e por fim traduz os parametros que foram passados para o modelo que o DataMapper precisa para realizar a consulta

## DataMapper
Responsável por carregar os dados baseado em filtros, ordená-los e retornar um ```array``` com os elementos

## Factories
A utilização de factories auxilia na manutenção futura, utilizando o princípio "Open Closed" do SOLID nós podemos criar novas classes e instancia-las sem edição do código já existente
##### Response Factory
Baseado no arquivo ```config.php``` que contém as configurações nós podemos instanciar novas classes. Por padrão utilizamos o json
```php
$app['response'] = [
    'type' => 'json',
];
```
Sendo assim a classe ```JsonResponseService``` será construída para trabalhar com o response. caso queira alterar a resposta, basta criar uma classe que implemente a interface ```ResponseInterface```. Ex:
```php
class XmlResponseService implements ResponseInterface
{
    public function makeWithException(\Exception $e)
    {
    ...
    }
    
    public function makeWithSuccess($data, $alerta)
    {
    ...
    }
}
```
E depois colocar o prefixo da classe no ```config.php```
```php
$app['response'] = [
    'type' => 'xml',
];
```
Essa abordagem facilita muito na escalabidade do sistema, o Response está desacoplado da regra de negócio

##### DataMapper Factory
Como a camada de persistência pode mudar e é comum mudar ao longo do tempo, eu preferi utilizar uma factory também, isso faz com que caso nós queiramos mudar a fonte de dados do arquivo ```vagas.json``` para um Banco de dados, só precisamos fazer o seguinte:
- Criar uma classe que implemente o ```DataMapperInterface```
```php
class VagasDatabaseDataMapper implements DataMapperInterface
{
    public function loadWithParams(array $filters, array $order)
    {
    ....
    }
}
```
- Alterar o ```config.php``` para carregar esta classe
```php
$app['database'] = [
    'name' => 'Database',
];
```




