<?Php

namespace App\Factories;

/**
 * Class DataMapperFactoryTest.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class DataMapperFactoryTest extends \PHPUnit_Framework_TestCase
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
                class_exists($class = '\App\Factories\DataMapperFactory'),
                'Class not found: '.$class
        );

        $this->assertInstanceOf('\Silex\Application', $this->app);
    }

    /**
     * Teste de factory em vagas deve retornar
     * una instancia de DataMapperInterface.
     */
    public function testFactoryToVagasDataMapperShouldWork()
    {
        $this->app['database'] = [
            'name' => 'json',
            'dbname' => dirname(__DIR__).'/vagas.json',
        ];

        $dm = $this->app['DataMapperFactory']->create('vagas');

        $this->assertInstanceOf('\App\Interfaces\DataMapperInterface', $dm);
    }

    /**
     * Teste de factory com um datamapper inexistente em uma bundle existente.
     *
     * @expectedException     \ReflectionException
     */
    public function testFactoryToVagaDataMapperJson2ShouldNotWork()
    {
        $this->app['database'] = [
            'name' => 'json2',
            'dbname' => dirname(__DIR__).'/vagas.json',
        ];

        $response = $this->app['DataMapperFactory']->create('vagas');
    }

    /**
     * Teste de factory com um datamapper existente em uma bundle inexistente.
     *
     * @expectedException     \ReflectionException
     */
    public function testFactoryToVagaDataMapperJsonWithWrongNameShouldNotWork()
    {
        $this->app['database'] = [
            'name' => 'json',
            'dbname' => dirname(__DIR__).'/vagas.json',
        ];

        $response = $this->app['DataMapperFactory']->create('vagas2');
    }
}
