<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$project_dir = __DIR__;

require_once $project_dir.'/../vendor/autoload.php';
use Core\Application;

$app = new Application(str_replace("/public", "", $project_dir));

include_once $project_dir.'/../app/routing/rules.php';

$render = $app->run();

if(empty($render)){
	die;
}
	
if(is_string($render)){
	echo $render;
	die;
}

var_dump($render);


