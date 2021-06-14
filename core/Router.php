<?php
namespace Core;

use BaseException;

class Router
{

	protected $request;
	protected $routes = [];
	
	public function __construct(Request $r){
		$this->request = $r;
	}
	
	public function get($path, $callback){
		$this->routes['get'][$path] = $callback;
	}

	public function post($path, $callback){
		$this->routes['post'][$path] = $callback;
	}

	public function put($path, $callback){
		$this->routes['put'][$path] = $callback;
	}

	public function delete($path, $callback){
		$this->routes['delete'][$path] = $callback;
	}

	public function multiple($methods, $path, $callback){
		$this->routes[implode("-", $methods)][$path] = $callback;
	}

	/*
	|--------------------------------------------------------------------------
	| resolve
	|--------------------------------------------------------------------------
	|
	| Handle server request. Finding routes and calling callback functions
	|
	*/

	public function resolve(){
		$path = $this->request->getPath();
		$method = $this->request->getMethod();
		$callback_response = $this->findCallback($path, $method);
		$callback = ($callback_response) ? $callback_response['name'] : false;
		$callback_params = ($callback_response) ? $callback_response['params'] : [];

		$callback_params = array_merge(['request' => $this->request],$callback_params);

		if($callback === false){
			throw new BaseException('No callback found');
		}

		if(!is_string($callback)){
			return call_user_func($callback);
		}

		$base_folders = ['App\Controllers'];
		$folders = explode("/", $callback);
		if(count($folders) > 1){
			$callable = $folders[count($folders)-1];
			unset($folders[count($folders)-1]);
			array_merge($base_folders,$folders);
		}else{
			$callable = $callback;
			$folders = $base_folders;
		}
		
		if(!preg_match("([A-z]\w+@[A-z]\w+)", $callable)){
			throw new BaseException('Callback structure define error');
		}

		$response = $this->getControllerAndMethod($callable);
		if(!$response){
			throw new BaseException('Callback method define error');
		}

		$controller = implode("\\", $folders).'\\'.$response['controller'];
		$method = $response['method'];
		$object = new $controller();

		return call_user_func_array([$object, $method], $callback_params);
	}

		private function findCallback($request_path, $request_method){
			$callback_by_method = [];
			foreach ($this->routes as $method => $path) {
				$tmp_methods = explode("-",$method);
				if(in_array($method,$tmp_methods)){
					foreach($path as $key => $value){
						$callback_by_method[$key] = $value;
					}
				}
			}

			if(empty($callback_by_method)){
				return false;
			}

			$exploded_request_path = explode("/",substr($request_path, 1));

			foreach ($callback_by_method as $path => $callback) {
				if($path == $request_path){
					return  [
						'name' => $callback,
						'params' => []
					];
				}

				$path = substr($path, 1);
				$exploded_path = explode("/",$path);
				if(count($exploded_request_path) == count($exploded_path)){
					$params = [];
					$ct = 0;
					foreach ($exploded_request_path as $key => $value) {
						if($exploded_path[$key] != $exploded_request_path[$key] && substr($exploded_path[$key], 0, 1) != '{'){
							$ct++;
						}

						if(substr($exploded_path[$key], 0, 1) == '{'){
							$params[str_replace("{", "", str_replace("}", "", $exploded_path[$key]))] = $exploded_request_path[$key];
						}

						if(!$ct){
							return  [
								'name' => $callback,
								'params' => $params
							];
						}
					}
				}
			}


			return false;
		}

		private function getControllerAndMethod($string){
			$tmp = explode("@",$string);
			if(count($tmp) != 2){
				return false;
			}

			return [
				'controller' => $tmp[0],
				'method' => $tmp[1]
			];
		}
}