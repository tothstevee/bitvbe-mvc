<?php

namespace Core;

class Request
{

	/*
	|--------------------------------------------------------------------------
	| getPath
	|--------------------------------------------------------------------------
	|
	| Get url from server
	|
	*/

	public function getPath(){
		$path = $_SERVER['REQUEST_URI'] ?? '/';
		$qmark = strpos($path, "?");

		if($qmark === false){
			return $path;
		}

		return substr($path, 0, $qmark);

	}

	/*
	|--------------------------------------------------------------------------
	| getMethod
	|--------------------------------------------------------------------------
	|
	| Get http method from server
	|
	*/

	public function getMethod(){
		return strtolower($_SERVER['REQUEST_METHOD']);
	}
}