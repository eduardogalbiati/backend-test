<?Php

namespace App\Vagas\DataMapper;

use Silex\Application;

use App\Interfaces\DataMapperInterface;
use App\Exceptions\DataMapperException;

/**
 * Class VagasJsonDataMapper
 * @package App
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class VagasJsonDataMapper implements DataMapperInterface
{
	/**
	 * @var Silex\Application
	 */
	protected $app;

	/**
	 * @var Array de vagas
	 */
	protected $collection;

	/**
	 * @var array com os filtros permitidos
	 */
	protected $allowedFilters = [
		'title',
		'description',
		'cidade'
	];

	/**
     * Método construtor
     * @param Silex\Applcation $app
     * @return void
     */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
     * Método responsável por carregar os dados aplicando os filtros e ordenações
     * @param Array $filters
     * @param Array $order
     * @return Array com vagas
     */
	public function loadWithParams(Array $filters, Array $order)
	{
		$this->collection = json_decode(file_get_contents($this->app['database']['dbname']), true);

		if(!$this->collection)
			throw new DataMapperException("Não foi possível carregar o arquivo JSON", 1);
			
		$this->applyFilters($filters);
		$this->applyOrder($order);

		return $this->collection['docs'];
	}

	/**
     * Método responsável por aplicar os filtros
     * @param Array $filters
     * @return void
     */
	private function applyFilters(array $filters)
	{
		//retorna caso não tenha sido especificado um filtro
		if(count($filters) == 0)
			return;

		//Aplica os filtros
		$this->collection['docs'] = array_filter(
			$this->collection['docs'],
			function ($item) use ($filters) {
				$ok = true;
				foreach ($this->allowedFilters as $field) {
					if($filters[$field] == '')
						continue;
					if(!$this->contentHasValue($item[$field], $filters[$field])) 
						$ok = false;
				}
				if($ok)
					return $item;
			}
		);
		
	}

	/**
     * Método responsável por checar se o valor está presente no item
     * @param String $content
     * @param String $value
     * @return boolean
     */
	private function contentHasValue($content, $value)
	{
		if(is_array($content)){
			if(in_array($value, $content))
				return true;
			return false;
		}

		if(stripos($content, $value) !== false)
			return true;
		
		return false;
	}

	/**
     * Método responsável por aplicar a ordenacao
     * @param Array $order
     */
	private function applyOrder(array $order)
	{
		if(count($order) == 0)
			return;

		if($order['order'] == 'asc')
			$this->orderAsc($order['field']);

		if($order['order'] == 'desc')
			$this->orderDesc($order['field']);
		
	}

	/**
     * Método responsável por ordenar ASC
     * @param String $field
     * @return void
     */
	private function orderAsc($field)
	{
		usort(
            $this->collection['docs'],
            function($a, $b) use ($field) {
            	return ($a[$field] < $b[$field]) ? -1 : 1;
            }
        );
		
	}

	/**
     * Método responsável por ordenar DESC
     * @param Integer $a, Integer $b
     * @param String $field
     * @return void
     */
	private function orderDesc($field)
	{
		usort(
            $this->collection['docs'],
            function($a, $b) use ($field) {
            	return ($a[$field] > $b[$field]) ? -1 : 1;
            }
        );
		
	}


}
