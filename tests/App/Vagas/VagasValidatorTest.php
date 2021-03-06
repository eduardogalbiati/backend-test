<?Php

namespace App\Vagas;

use App\Vagas\Validator\VagasValidator;

/**
 * Class VagasJsonDataMapper.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class VagasValidatorTest extends \PHPUnit_Framework_TestCase
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
                class_exists($class = '\App\Vagas\Validator\VagasValidator'),
                'Class not found: '.$class
        );
        $this->assertInstanceOf('\Silex\Application', $this->app);
    }

    /**
     * Teste de validação com dados ok.
     */
    public function testValidatorWithCorrectDataShouldWork()
    {
        $query = [
            'title' => 'title',
            'description' => 'description',
            'cidade' => 'cidade',
            'order' => 'asc',
            'field' => 'salario',
        ];

        $validatedQuery = VagasValidator::validate($query);

        $this->assertEquals($query, $validatedQuery);
    }

    /**
     * Teste de validação com conteudo inválido.
     *
     * @expectedException     App\Exceptions\ValidatorException
     */
    public function testValidateWithWrongParametersShouldThrowException()
    {
        $query = [
            'order' => 'asc2',
        ];

        $validatedQuery = VagasValidator::validate($query);
    }

    /**
     * Teste de sanitize no title pelo TRIM.
     */
    public function testValidateSanitizeTrim()
    {
        $query = [
            'title' => ' asd ',
        ];

        $validatedQuery = VagasValidator::validate($query);

        $this->assertEquals('asd', $validatedQuery['title']);
    }

    /**
     * Teste na função que segrega os filtros da query.
     */
    public function testGetFilters()
    {
        $query = [
            'title' => 'title',
            'description' => 'description',
            'cidade' => 'cidade',
            'order' => 'asc',
            'field' => 'salario',
        ];

        $filters = VagasValidator::getFiltersFromQuery($query);

        $expectedFilters = [
            'title' => 'title',
            'description' => 'description',
            'cidade' => 'cidade',
        ];

        $this->assertEquals($expectedFilters, $filters);
    }

    /**
     * Teste na função que segrega os dados de ordenção da query.
     */
    public function testGetOrder()
    {
        $query = [
            'title' => 'title',
            'description' => 'description',
            'cidade' => 'cidade',
            'order' => 'asc',
            'field' => 'salario',
        ];

        $order = VagasValidator::getOrderFromQuery($query);

        $expectedOrder = [
            'order' => 'asc',
            'field' => 'salario',
        ];

        $this->assertEquals($expectedOrder, $order);
    }
}
