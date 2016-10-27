<?Php

namespace App\Vagas;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Vagas\Service\VagasService;

/**
 * Class VagasJsonDataMapper
 * @package App
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class VagasServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Silex\Application $app
     */ 
    protected $app;

    /**
     * Método que cria o Silex\Application
     * @return void
     */
    function setUp()
    {
        parent::setUp();
        $this->app = createApplication();
    }

    /**
     * Teste de dependencias para o teste
     * @return void
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
     * Teste de listagem sem filtros
     * @return void
     */
    public function testLoadMethodResponse()
    {
        $res = $this->app['vagas.service']->loadData([]);

        $file = json_decode(file_get_contents('vagas.json'),true);

        $this->assertEquals($file['docs'], $res);
        $this->assertInternalType('array', $res);

    }
   
} 
