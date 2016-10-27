<?Php

namespace App\Factories;

use Silex\Application;

/**
 * Class DataMapperFactory
 * @package App
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class DataMapperFactory
{
	/**
     * @var \Silex\Application $app
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
     * Factory para criação de classe de response
     * @return ResponseInterface
     */
	function create($bundle)
	{
		$bundle = ucfirst($bundle);
		$path = ucfirst($this->app['database']['name']);

        $reflection = new \ReflectionClass('App\\'.$bundle.'\\DataMapper\\'.$bundle.$path. 'DataMapper');
        return $reflection->newInstanceArgs([$this->app]);
	}
}