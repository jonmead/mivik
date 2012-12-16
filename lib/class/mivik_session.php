<?php 
class mivik_session{
	function __set($k, $v){
		$_SESSION[$k] = $v;
	}
	function __get($var){
		if(array_key_exists($var, $_SESSION)){
			return $_SESSION[$var];
		}else{
			return null;
		}
	}
}