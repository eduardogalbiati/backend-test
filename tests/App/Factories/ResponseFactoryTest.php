<?Php

namespace App\Factories;

/**
 * Class VagasJsonDataMapper.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class ResponseFactoryTest extends \PHPUnit_Framework_TestCase
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
                class_exists($class = '\App\Factories\ResponseFactory'),
                'Class not found: '.$class
        );
        $this->assertInstanceOf('\Silex\Application', $this->app);
    }

    /**
     * Teste de factory em response deve retornar
     * una instancia de JsonResponseInterface.
     */
    public function testFactoryToJson()
    {
        $this->app['response'] = [
            'type' => 'json',
        ];

        $response = $this->app['ResponseFactory']->create();

        $this->assertInstanceOf('\App\Services\JsonResponseService', $response);
    }

    /**
     * Teste de factory para um tipo de resposta inexistente.
     *
     * @expectedException     \ReflectionException
     */
    public function testFactoryToJson2ShouldNotWork()
    {
        $this->app['response'] = [
            'type' => 'json2',
        ];

        $response = $this->app['ResponseFactory']->create();

        $this->assertInstanceOf('\App\Services\JsonResponseService', $response);
    }
}
