<?php

/*
 * Neste arquivo estão as configurações do aplicativo
 * que podem ser utilizadas pelos services do container
 *
 */

$app['debug'] = true;

$app['database'] = [
	'name' => 'json',
	'dbname' => dirname(__DIR__).'/vagas.json'
];

$app['response'] = [
	'type' => 'json',
];