<?php
/** 
* include *.php files in a directory
* @param string $path Absolute path to a directory containing .php files
* @param string $pattern optional argument, can include files with different
* extensions. The default is to include '*.php', but it is friendly to other
* file extensions by passing something like '*.inc.php'
*/
function includePhpFilesInDir($path, $pattern='*.php'){
	global $r;
	if(is_dir($path)){
		foreach (glob($path.'/'.$pattern) as $file) {
			include_once ($file);
		}
	}
}

/**
*Include the given file if it exists
* @param string $path absolute path to a file
*/
function includeIfExists($path){
	global $r;
	if(file_exists($path)){
		include $path;
	}
}

/**
 * Check if a string ends with the specified substring
* @param string $needle search term
* @param string $haystack string to search
 * @return true if the string ends with the substring
 */
function stEndsWith($needle, $haystack){
	$substring = substr($haystack, -1*strlen($needle));
	return $substring==$needle;
}

/**
* By convention, a view lives in {appBase}/app/action/{controllerName}/{actionName.php}
* There are 3 files on the controller level that can be included as part of the request
* 1. Folder controller (optional):{appBase}/app/action/{controllerName}/{controllerName}.master.c.php
*     A folder controller should contain functions and logic used by more than one of the actions
* 2. View controller (optional):  {appBase}/app/action/{controllerName}/{actionName}.c.php
*     A view controller should contain all logic and functions needed to serve it's corresponding action
* 3. View file (required):        {appBase}/app/action/{controllerName}/{actionName}.php
*     A view file should only contain presentation logic (print/loops/etc) and shouldn't have any business
*     logic
* @param string $controller the name of a folder in app/action
* @param string $action the name of an action in one of the app/action/ folders
*/
function bufferOutput($controller, $action){
	global $r;
	$masterController = $r->appBase."/app/action/{$controller}/{$controller}.master.c.php";
    $viewController = $r->appBase."/app/action/{$controller}/{$action}.c.php";
    $viewFile = $r->appBase."/app/action/{$controller}/{$action}.php";

    if(!ob_start())
            die("could not start output buffering");
    if(file_exists($masterController))
    	include ($masterController);
    if(file_exists($viewController))
    	include ($viewController);
    if(file_exists($viewFile))
    	include ($viewFile);
    
    return ob_get_clean();
}
