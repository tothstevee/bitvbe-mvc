<?php
namespace Core;

class Application
{
	public static $ROOT_DIR;
	public $router;
	protected $request;

	public function __construct($rootPath)
	{
		self::$ROOT_DIR = $rootPath;
		$this->request = new Request();
		$this->router = new Router($this->request);
	}

	/*
	|--------------------------------------------------------------------------
	| run
	|--------------------------------------------------------------------------
	|
	| Core function this handle routes and returning response
	|
	*/

	public function run(){
		return $this->router->resolve();
	}
}