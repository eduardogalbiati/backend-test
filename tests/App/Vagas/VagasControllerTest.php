<?Php

namespace App\Vagas;

use Symfony\Component\HttpFoundation\Request;
use App\Vagas\Controller\VagasController;

/**
 * Class VagasJsonDataMapper.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class VagasControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Silex\Application
     */
    protected $app;

    /**
     * Método que cria o Silex\Application.
     */
    public function setUp()
    {
        parent::setUp();
        $this->app = createApplication();
    }

    /**
     * Teste de dependencias para o teste.
     */
    public function assertPreConditions()
    {
        $this->assertTrue(
                class_exists($class = '\App\Vagas\Controller\VagasController'),
                'Class not found: '.$class
        );

        $this->assertInstanceOf('\Silex\Application', $this->app);
    }

    /**
     * Teste de resposta do controller caso tudo ok.
     */
    public function testListResponseOk()
    {
        $ctrl = new VagasController($this->app);

        $response = $ctrl->listVagas(Request::create(
            'api/v1/vagas',
            'GET'
        ));

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals('200', $response->getStatusCode());
    }

    /**
     * Teste de resposta do controller caso tenha problemas
     * no carregamento de informações.
     */
    public function testListResponseException()
    {
        //definindo uma variável errada para lançar exceções
        $app = $this->app;
        $app['database'] = [
            'dbname' => 'xxx',
            'name' => 'xxx',
            ];

        $ctrl = new VagasController($app);

        $response = $ctrl->listVagas(Request::create(
            'api/v1/vagas',
            'GET'
        ));

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals('400', $response->getStatusCode());
    }
}
