<?php

/*
|--------------------------------------------------------------------------
| Dev mode
|--------------------------------------------------------------------------
|
| Display all php errors in development mode
|
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/*
|--------------------------------------------------------------------------
| Autoload
|--------------------------------------------------------------------------
|
|	Require composer autoload file
|
*/

$project_dir = __DIR__;

require_once $project_dir.'/../vendor/autoload.php';


/*
|--------------------------------------------------------------------------
| Init
|--------------------------------------------------------------------------
|
| Init application
|
*/

use Core\Application;

$app = new Application(str_replace("/public", "", $project_dir));

/*
|--------------------------------------------------------------------------
| Routing
|--------------------------------------------------------------------------
|
| Import routes from rules file
|
*/

include_once $project_dir.'/../app/routing/rules.php';

/*
|--------------------------------------------------------------------------
| Run
|--------------------------------------------------------------------------
|
| Call core function from application and handle response
|
*/

$render = $app->run();
	
if(is_string($render)){
	echo $render;
	die;
}

var_dump($render);


