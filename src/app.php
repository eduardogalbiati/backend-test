<?php

/*
 * Este arquivo é responsável pela criação do Silex\Application
 *
 */

use Silex\Application;

$app = new Application();

require dirname(__DIR__).'/src/config.php';
require dirname(__DIR__).'/src/services.php';

return $app;
