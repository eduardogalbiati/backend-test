<?Php

namespace App\Vagas;

use App\Vagas\DataMapper\VagasJsonDataMapper;

/**
 * Class VagasJsonDataMapper.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class VagasJsonDataMapperTest extends \PHPUnit_Framework_TestCase
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
                class_exists($class = '\App\Vagas\DataMapper\VagasJsonDataMapper'),
                'Class not found: '.$class
        );
        $this->assertInstanceOf('\Silex\Application', $this->app);

        $this->dm = new VagasJsonDataMapper($this->app);
    }

    /**
     * Teste de listagem sem filtros.
     */
    public function testLoadWithParams()
    {
        $res = $this->dm->loadWithParams($filters = [], $order = []);

        $file = json_decode(file_get_contents('vagas.json'), true);

        $this->assertEquals($file['docs'], $res);
    }

    /**
     * Teste de listagem com um nome de arquivo inválido.
     *
     * @expectedException     App\Exceptions\DataMapperException
     */
    public function testeWrongFilePathShouldThrowException()
    {
        $appTest = $this->app;
        $appTest['database'] = [
            'dbname' => './',
        ];

        $dm = new VagasJsonDataMapper($appTest);
        $res = $this->dm->loadWithParams($filters = [], $order = []);
    }

    /**
     * Teste de listagem com filtro TITLE e somente 1 resultado.
     */
    public function testGetByTitleWithOneResult()
    {
        $item = [
            'title' => 'Analista de Suporte de TI',
            'description' => '<li> Prestar atendimento remoto e presencial a clientes. Atuar com suporte de TI.</li><li> Conhecimento aprofundado em Linux Server (IPTables, proxy, mail, samba) e Windows Server(MS-AD, WTS, compartilhamentos).</li>',
            'salario' => 3200,
            'cidade' => [
                'Joinville',
            ],
            'cidadeFormated' => [
                'Joinville - SC (1)',
            ],
        ];

        $res = $this->dm->loadWithParams(
            $filters = [
                'title' => $item['title'],
                'description' => '',
                'cidade' => '',
            ],
            $order = [
                'order' => '',
                'field' => '',
            ]
        );

        $this->assertEquals(1, count($res));
        $this->assertContains($item, $res);
    }

    /**
     * Teste de listagem com filtro TITLE e vários resultados.
     */
    public function testGetByTitleWithMultipĺeResults()
    {
        $item = [
            'title' => 'Recepcionista',
            'description' => '<li> Monitorar toda área e barreiras perimetrais; Liberar a entrada de colaboradores na empresa; Fazer a identificação das pessoas que transitam pelas portarias; Registrar os terceiros que acessam a empresa; Conhecer as normas internas de segurança e orientar os colaboradores quanto ao seu cumprimento; Conferir as saídas e entradas de produtos com os documentos hábeis na Portaria; Controlar o acesso pelo sistema informatizado de imagens.</li><li> Ensino Médio Completo. Desejável vivência em Segurança Patrimonial/Portaria de indústria e conhecimento em informática. </li>',
            'salario' => 1304.41,
            'cidade' => [
                'Joinville',
            ],
            'cidadeFormated' => [
                'Joinville - SC (1)',
            ],
        ];

        $res = $this->dm->loadWithParams(
            $filters = [
                'title' => $item['title'],
                'description' => '',
                'cidade' => '',
            ],
            $order = [
                'order' => '',
                'field' => '',
            ]
        );

        $this->assertEquals(23, count($res));
        $this->assertContains($item, $res);
    }

    /**
     * Teste de listagem com filtro TITLE e DESCRIPTION.
     */
    public function testTitleAndDescriptionFilterTogheter()
    {
        $item = [
            'title' => 'Recepcionista',
            'description' => '<li> Monitorar toda área e barreiras perimetrais; Liberar a entrada de colaboradores na empresa; Fazer a identificação das pessoas que transitam pelas portarias; Registrar os terceiros que acessam a empresa; Conhecer as normas internas de segurança e orientar os colaboradores quanto ao seu cumprimento; Conferir as saídas e entradas de produtos com os documentos hábeis na Portaria; Controlar o acesso pelo sistema informatizado de imagens.</li><li> Ensino Médio Completo. Desejável vivência em Segurança Patrimonial/Portaria de indústria e conhecimento em informática. </li>',
            'salario' => 1304.41,
            'cidade' => [
                'Joinville',
            ],
            'cidadeFormated' => [
                'Joinville - SC (1)',
            ],
        ];

        $res = $this->dm->loadWithParams(
            $filters = [
                'title' => 'Recepcionista',
                'description' => 'atuar',
                'cidade' => '',
            ],
            $order = [
                'order' => '',
                'field' => '',
            ]
        );

        $this->assertEquals(8, count($res));
        $this->assertNotContains($item, $res);
    }

    /**
     * Teste de listagem com filtro DESCRIPTION com mais de 1 resultado.
     */
    public function testGetByDescriptionWithMultipleResults()
    {
        $item = [
            'title' => 'Auxiliar Administrativo',
            'description' => '<li> Atendimento telefônico, controle de agendamentos, recepcionar pacientes e atualização cadastral dos pacientes.</li><li> Experiência em Excel, Word e Internet.</li><li> Ensino Médio completo.</li>',
            'salario' => 1200,
            'cidade' => [
                'Florianópolis',
            ],
            'cidadeFormated' => [
                'Florianópolis - SC (1)',
            ],
        ];

        $res = $this->dm->loadWithParams(
            $filters = [
                'title' => '',
                'description' => 'controle de agendamentos',
                'cidade' => '',
            ],
            $order = [
                'order' => '',
                'field' => '',
            ]
        );

        $this->assertEquals(2, count($res));
        $this->assertContains($item, $res);
    }

    /**
     * Teste de listagem com filtro CIDADE.
     */
    public function testCidadeFilter()
    {
        $res = $this->dm->loadWithParams(
            $filters = [
                'title' => '',
                'description' => '',
                'cidade' => 'Joinville',
            ],
            $order = [
                'order' => '',
                'field' => '',
            ]
        );

        $this->assertEquals(92, count($res));
    }

    /**
     * Teste de listagem com filtro CIDADE + DESCRIPTION.
     */
    public function testCidadeWithDescriptionFilter()
    {
        $res = $this->dm->loadWithParams(
            $filters = [
                'title' => '',
                'description' => 'atuar',
                'cidade' => 'Joinville',
            ],
            $order = [
                'order' => '',
                'field' => '',
            ]
        );

        $this->assertEquals(24, count($res));
    }

    /**
     * Teste de listagem com filtro CIDADE + TITLE.
     */
    public function testCidadeWithTitleFilter()
    {
        $res = $this->dm->loadWithParams(
            $filters = [
                'title' => 'Recepcionista',
                'description' => '',
                'cidade' => 'Joinville',
            ],
            $order = [
                'order' => '',
                'field' => '',
            ]
        );

        $this->assertEquals(2, count($res));
    }

    /**
     * Teste de listagem com filtro CIDADE + TITLE + DESCRIPTION.
     */
    public function testCidadeWithDescriptionAndTitleFilter()
    {
        $res = $this->dm->loadWithParams(
            $filters = [
                'title' => 'Recepcionista',
                'description' => 'Controlar',
                'cidade' => 'Joinville',
            ],
            $order = [
                'order' => '',
                'field' => '',
            ]
        );

        $this->assertEquals(1, count($res));
    }

    /**
     * Teste de ordenação do SALARIO ASC.
     */
    public function testSalarioOrderAsc()
    {
        $res = $this->dm->loadWithParams(
            $filters = [],
            $order = [
                'field' => 'salario',
                'order' => 'asc',
            ]
        );

        // Assert nos extremos do array
        $this->assertEquals(750, $res[0]['salario']);
        $this->assertEquals(11000, $res[count($res) - 1]['salario']);

        $value = 0;
        foreach ($res as $key => $item) {
            $this->assertGreaterThanOrEqual($value, $item['salario']);
            $value = $item['salario'];
        }
    }

    /**
     * Teste de ordenação do SALARIO DESC.
     */
    public function testSalarioOrderDesc()
    {
        $res = $this->dm->loadWithParams(
            $filters = [],
            $order = [
                'field' => 'salario',
                'order' => 'desc',
            ]
        );

        // Assert nos extremos do array
        $this->assertEquals(11000, $res[0]['salario']);
        $this->assertEquals(750, $res[count($res) - 1]['salario']);

        //var_dump($res);die;
        $value = 0;
        $c = count($res) - 1;
        while ($c > 0) {
            $this->assertGreaterThanOrEqual($value, $res[$c]['salario']);
            $value = $res[$c]['salario'];
            --$c;
        }
    }
}
