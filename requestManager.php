<?php
#determine the real path for the application base directory
$mivik_appbase = str_replace("\\", "/", realpath(dirname($_SERVER['SCRIPT_FILENAME'])."/../"));
$mivik_framebase = str_replace("\\", "/", realpath(dirname(__FILE__)));

include "$mivik_framebase/lib/mivikGlobalFunctions.php";

#framework includes
includePhpFilesInDir("$mivik_framebase/lib/interface");
includePhpFilesInDir("$mivik_framebase/lib/class");

# setup the mivik request object, this is automatically available as
# $r in every template, action, and controller file
$r = new mivik_request();
$r->appBase = $mivik_appbase;
#setup application config
$r->config = new mivik_config();
$r->config->parseFile($r->appBase.'/app/appConfig.ini');
$r->args = new mivik_args();
#app hook, allow other config files
includeIfExists($r->appBase.'/app/hook/01configHook.php'); 

#use sessions based on config value in app/appConfig.ini
if($r->config->use_sessions == TRUE){
	session_start();
	$r->session = new mivik_session();
}

#app hook, entry point for app includes
includeIfExists($r->appBase."/app/hook/02includeHook.php"); 

$r->url = new mivik_url(isset($_SERVER['HTTPS'])?"https://":"http://". $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
#figure out what to serve based on the url and whether the view file exists
# setup default action from appConfig.ini
	$r->activeController= $r->config->default_controller;
	$r->activeAction = $r->config->default_action;

if($r->url->controller != NULL && $r->url->action != NULL){ #both provided in the url
	if(file_exists($r->appBase."/app/action/{$r->url->controller}/{$r->url->action}.php")){
		$r->activeController = $r->url->controller;
		$r->activeAction = $r->url->action;
	}elseif(!$r->config->serve_default_instead_of_404){
		include $mivik_framebase."/htm/404.php";
	}
}
$r->args->post = $_POST;
$r->args->get = $_GET;
includeIfExists($r->appBase."/app/hook/03appHook.php");

$r->activeTemplate = $r->config->default_template;
$r->actionOutput = bufferOutput($r->activeController, $r->activeAction);
require $r->appBase."/app/template/{$r->activeTemplate}.php";
