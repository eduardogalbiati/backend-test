<?Php

namespace App\Vagas;

/**
 * Class VagasJsonDataMapper.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class VagasServiceTest extends \PHPUnit_Framework_TestCase
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
                class_exists($class = '\App\Vagas\Service\VagasService'),
                'Class not found: '.$class
        );
        $this->assertInstanceOf('\Silex\Application', $this->app);
    }

    /**
     * Teste de listagem sem filtros.
     */
    public function testLoadMethodResponse()
    {
        $res = $this->app['vagas.service']->loadData([]);

        $file = json_decode(file_get_contents('vagas.json'), true);

        $this->assertEquals($file['docs'], $res);
        $this->assertInternalType('array', $res);
    }
}
