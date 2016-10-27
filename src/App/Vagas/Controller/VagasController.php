<?php

namespace App\Vagas\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class VagasController.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class VagasController
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
     * Método responsável pela listagem das vagas, sua responsabilidade é
     * 1. Obter os dados do Request (Query)
     * 2. Acionar o Service passando os dados obtidos
     * 3. Construir e retornar o Response.
     *
     * @param Request $request;
     *
     * @return \Response;
     */
    public function listVagas(Request $request)
    {
        // Construindo o Response
        $response = $this->app['ResponseFactory']->create();

        // Delegando a responsabilidade para o service
        try {
            $data = $this->app['vagas.service']->loadData($request->query->all());
        } catch (\Exception $e) {
            return $response->makeWithException($e);
        }

        // Retornando o Response
        return $response->makeWithSuccess($data, 'Listagem realizada com sucesso');
    }
}
