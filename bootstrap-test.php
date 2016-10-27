<?php
/**
 * PhpUnit Tests
 *
 * The global configuration for the tests.
 */
if(! defined("ROOT")):
    define("ROOT", (__DIR__));
endif;
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
date_default_timezone_set('America/Sao_Paulo');
include_once 'vendor/autoload.php';

/**
 * cria uma instancia do Sliex.
 * @return Silex\Application
 */
function createApplication() {

    $app = require  ROOT.'/src/app.php';
    
    $app["debug"] = true;
    //var_dump($app['database']);die;
	unset($app['exception_handler']);
    return $app;
}