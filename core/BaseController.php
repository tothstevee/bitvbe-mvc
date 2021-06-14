<?php

namespace Core;

abstract class BaseController
{

	/*
	|--------------------------------------------------------------------------
	| response
	|--------------------------------------------------------------------------
	|
	| Handle the response from controllers
	|
	*/

	public function response($response = false){
		$response = new Response();
		return $response;
	}

	/*
	|--------------------------------------------------------------------------
	| redirect
	|--------------------------------------------------------------------------
	|
	| Handle the redirect from controllers
	|
	*/

	public function redirect(){
		return new Redirect();
	}
}