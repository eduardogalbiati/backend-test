<?php

/*
 * Este arquivo é o Front-Controller
 * Responsável pelo autoload e rotas
 *
 */

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Cria instância de Silex\Application e armazena em $app
require_once dirname(__DIR__).'/src/app.php';

// Define a rota
$app->get( 'api/v1/vagas', function (Request $request) use ($app) {
    $ctrl = new App\Vagas\Controller\VagasController($app);
    return $ctrl->listVagas($request);
});

// Executa o Silex\Application
$app->run();
