<?php

/*
 * Este arquivo é o Front-Controller
 * Responsável pelo autoload e rotas
 *
 */

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once dirname(__DIR__).'/src/app.php';

$app->get( 'api/v1/vagas', function (Request $request) use ($app) {
    $ctrl = new App\Vagas\Controller\VagasController($app);
    return $ctrl->listVagas($request);
});

$app->run();
