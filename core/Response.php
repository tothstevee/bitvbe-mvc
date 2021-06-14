<?php
namespace Core;
class Response
{
	public function json($content = [], $code = 204){
		if(!empty($content) && $code = 204){
			$code = 200;
		}

		http_response_code($code);
		header('Content-Type: application/json');
		echo json_encode($content);
	}

	public function view($app__view, $app__params = [], $app__code = 200){
		http_response_code($app__code);
		return new View($app__view, $app__params);
	}

}