<?Php

/*
 * Neste arquivo estão as Closures para criação dos services
 * que serão registrados no Container (Pimple)
 *
 */

$app['vagas.service'] = function ($app) {
    return new App\Vagas\Service\VagasService($app);
};

$app['ResponseFactory'] = function ($app) {
	return new App\Factories\ResponseFactory($app);
};

$app['DataMapperFactory'] = function($app) {
	return new App\Factories\DataMapperFactory($app);
};