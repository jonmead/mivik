<?php 
class mivik_url{
	public $fullUrl;
	public $baseUrl;
	public $controller;
	public $action;
	public $args;
	
	public function __construct($url){
		$this->setUrl($url);
	}
	
	//helpers
	/**
	 * Process the url to compute the base portion (includes the trailing slash
	 * prior to index.php or where it would be)
	 * 
	 * Input:  http://domain/app/index.php/controller/action/arg0/arg1/...
	 * Output: http://domain/app/
	 * 
	 * Input:  http://domain/app
	 * Output: http://domain/app/
	 */
	private function computeBaseUrl(){
		if(!strpos($this->fullUrl, 'index.php')){ //index.php was not provided
			$this->baseUrl = $this->fullUrl;
			if(!$this->hasTrailingSlash($this->baseUrl)){
				$this->baseUrl .= '/';
			}
		}else{
			$this->baseUrl = substr($this->fullUrl,0,strpos($this->fullUrl, "index.php"));
		}
	}
	
	/**
	 * Processes the request url to determine if a controller, action, and
	 * arguments are provided via url.
	 */
	private function computePartsAfterIndex(){
		$this->controller = NULL;
		$this->action = NULL;
		$this->args = array();
		
		$parts = explode("/", $this->fullUrl);
		
		$positionOfIndex = -1;
		for($i = 0; $i < sizeof($parts); $i++){
			if($parts[$i] == 'index.php'){
				$positionOfIndex = $i;
			}elseif($positionOfIndex>-1 && $i==$positionOfIndex+1){
				$this->controller = $parts[$i];
			}elseif($positionOfIndex>-1 && $i == $positionOfIndex+2){
				$this->action = $parts[$i];
			}elseif($positionOfIndex>-1 && $i > $positionOfIndex+2){
				$arg = trim($parts[$i]);
				if(strlen($arg) > 0){
					array_push($this->args, $parts[$i]);
				}
			}
		}
	}
	public function setUrl($url){
		$this->fullUrl = $url;
		$this->computeBaseUrl();
		$this->computePartsAfterIndex();
	}
	
	public function getCssUrl($pathInCss){
		return $this->baseUrl ."css/$pathInCss";
	}
	public function outputCssTag($pathInCss, $justReturnTheTag=FALSE){
		$result = "<link rel='stylesheet' href='".$this->getCssUrl($pathInCss)."'/>\n";
		if(!$justReturnTheTag){
			echo $result;
		}
		return $result;
	}
	public function getJsUrl($pathInJs){
		return $this->baseUrl ."js/$pathInJs";
	}
	public function outputJsTag($pathInJs, $justReturnTheTag=FALSE){
		$result = "<script type='text/javascript' src='".$this->getJsUrl($pathInJs)."'></script>\n";
		if(!$justReturnTheTag){
			echo $result;
		}
		return $result;
	}
	public function getImgUrl($pathInImg){
		return $this->baseUrl ."img/$pathInImg";
	}
	public function outputImgTag($pathInImg, $alt=NULL, $justReturnTheTag=FALSE){
		$result = "<img src='".$this->getImgUrl($pathInImg)."' alt='$alt'/>\n";
		if(!$justReturnTheTag){
			echo $result;
		}
		return $result;
	}
	public function getActionLink($controllerName, $actionName){
		return $this->baseUrl."index.php/$controllerName/$actionName";
	}
	/**
	 * Returns true if the provided string ends with a backslash
	 * @param String $str
	 */
	private function hasTrailingSlash($str){
		return substr($str, -1) =='/';
	}
}