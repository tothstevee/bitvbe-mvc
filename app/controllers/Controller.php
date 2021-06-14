<?php

namespace App\Controllers;

use Core\BaseController;
use Core\Request;

class Controller extends BaseController
{
	
	function hello(Request $r){
		return $this->response()->view("test", ['name' => 'Tóth István'])->render();
	}
}