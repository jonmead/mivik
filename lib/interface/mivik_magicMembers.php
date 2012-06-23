<?php
class mivik_magicMembers{
	function __set($k, $v){
		$this->{$k} = $v;
	}
	function __get($var){
		return null;
	}
}