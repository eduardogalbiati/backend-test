<?Php

namespace App\Factories;

use Silex\Application;

/**
 * Class ResponseFactory.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmaiol.com>
 */
class ResponseFactory
{
    /**
     * @var Silex\Application
     */
    protected $app;

    /**
     * Método construtor.
     *
     * @param Silex\Applcation $app
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
    public function create()
    {
        $path = ucfirst($this->app['response']['type']);

        $reflection = new \ReflectionClass('App\\Services\\'.$path.'ResponseService');

        return $reflection->newInstanceArgs([$this->app]);
    }
}
