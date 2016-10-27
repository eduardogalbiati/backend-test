<?Php

namespace App\Interfaces;

/**
 * Interface DataMapperInterface
 * @package App
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
interface DataMapperInterface
{
	/**
     * Método construtor
     * @param Silex\Applcation $app
     * @return void
     */
	function __construct(\Silex\Application $app);

	/**
     * Método responsável por carregar os dados aplicando os filtros e ordenações
     * @param Array $filters
     * @param Array $order
     * @return Array com dados
     */
	public function loadWithParams(Array $filters, Array $order);
}