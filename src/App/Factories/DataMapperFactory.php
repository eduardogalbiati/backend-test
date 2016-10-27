<?Php

namespace App\Factories;

use Silex\Application;

/**
 * Class DataMapperFactory.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class DataMapperFactory
{
    /**
     * @var \Silex\Application
     */
    protected $app;

    /**
     * Método construtor.
     *
     * @param Silex\Applcation $app;
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Factory para criação de classe de response.
     *
     * @return ResponseInterface
     */
    public function create($bundle)
    {
        $bundle = ucfirst($bundle);
        $path = ucfirst($this->app['database']['name']);

        $reflection = new \ReflectionClass('App\\'.$bundle.'\\DataMapper\\'.$bundle.$path.'DataMapper');

        return $reflection->newInstanceArgs([$this->app]);
    }
}
