<?php

namespace Core;

class BaseController
{

	public function response($response = false){
		$response = new Response();
		return $response;
	}

	public function redirect(){
		return new Redirect();
	}
}