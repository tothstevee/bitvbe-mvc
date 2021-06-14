<?php
namespace Core;

class Redirect
{

	/*
	|--------------------------------------------------------------------------
	| route
	|--------------------------------------------------------------------------
	|
	| Redirecting request to defined route by name
	|
	*/

	public function route($name, $params){
		$url = $this->getRouteByName($name) ?? false;

		if(!$url){
			return flase;
		}

		foreach ($params as $key => $value) {
			$url = str_replace("{".$key."}", $value, $url);
		}

		header('Location: '.$url);
		die;
	}

		private function getRouteByName($name){

		}

	/*
	|--------------------------------------------------------------------------
	| url
	|--------------------------------------------------------------------------
	|
	| Redirecting request to external / internal url
	|
	*/

	public function url($url = ""){
		if(empty($url)){
			return false;
		}

		header('Location: '.$url);
		die;
	}
}