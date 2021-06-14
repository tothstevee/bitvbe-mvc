<?php

namespace Core;

class Request
{
	public function getPath(){
		$path = $_SERVER['REQUEST_URI'] ?? '/';
		$qmark = strpos($path, "?");

		if($qmark === false){
			return $path;
		}

		return substr($path, 0, $qmark);

	}

	public function getMethod(){
		return strtolower($_SERVER['REQUEST_METHOD']);
	}
}