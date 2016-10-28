<?Php

namespace App\Interfaces;

/**
 * Interface DataMapperInterface.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
interface DataMapperInterface
{
    /**
     * Método construtor.
     *
     * @param Silex\Applcation $app
     */
    public function __construct(\Silex\Application $app);

    /**
     * Método responsável por carregar os dados aplicando os filtros e ordenações.
     *
     * @param array $filters
     * @param array $order
     *
     * @return array com dados
     */
    public function loadWithParams(array $filters, array $order);
}
