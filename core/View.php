<?php

namespace Core;

class View{
	protected $name;
	protected $params;
	protected $layout;

	public function __construct($name, $params = []){
		$this->params = $params;
		$this->name = $name;
	}

	/*
	|--------------------------------------------------------------------------
	| setLayout
	|--------------------------------------------------------------------------
	|
	| Set view current layout
	|
	*/

	private function setLayout($layout){
		$this->layout = $layout;
	}

	/*
	|--------------------------------------------------------------------------
	| render
	|--------------------------------------------------------------------------
	|
	| Render the view, import layout and set variables
	|
	*/

	public function render(){
		$content = $this->getViewContent($this->name) ?? false;

		if(!$content){
			return false;
		}

		$matches = [];
		preg_match_all("/@extend\(\'+([A-z])*\'\)/",$content, $matches);

		if(isset($matches[0][0])){
			$layout_name = str_replace(["@extend('","')"],['',''],$matches[0][0]);
			$content = str_replace($matches[0][0], '', $content);
			$layout = $this->getViewContent($layout_name) ?? false;
		}

		if(isset($layout) && $layout){
			return str_replace('@content', $content, $layout);
		}

		return $content;		
	}

		/*
		|--------------------------------------------------------------------------
		| getViewContent
		|--------------------------------------------------------------------------
		|
		| Get the rendered content from view file
		|
		*/

		private function getViewContent($view_file){
			$view_file =  Application::$ROOT_DIR.'/app/views/'.$view_file.'.view.php';

			if(file_exists($view_file)){
				ob_start();
				foreach ($this->params as $key => $value) {
					$$key = $value;
				}
				include_once $view_file;
				return ob_get_clean();
			}

			return false;
		}

}