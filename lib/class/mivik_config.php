<?php
class mivik_config extends mivik_magicMembers{
	public function parseFile($path){
		if(file_exists($path)){
			$configItems = parse_ini_file($path);
			foreach($configItems as $k=>$v){
				$this->$k = $v;
			}
		}
	}
}