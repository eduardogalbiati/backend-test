<?Php

namespace App\Vagas\Service;

use Silex\Application;

use App\Vagas\Validator\VagasValidator;

/**
 * Class VagasService
 * @package App
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class VagasService
{
	/**
	 * @var Silex\Application
	 */
	protected $app;

	/**
     * Método construtor
     * @param Silex\Applcation $app;
     * @return void
     */
	function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
     * Método responsável pela listagem das vagas, sua responsabilidade é
     * 1. Acionar a factory para obtenção do DataMapper
     * 2. Validar os dados provenientes da query
     * 3. Acionar Chamar o dataMapper passando a query limpa
     * @param Array $query;
     * @return Array com os itens listados;
     */
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
}