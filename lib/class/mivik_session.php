<?php 
class mivik_session extends mivik_magicMembers{
	public function mivik_session(){
		foreach ($_SESSION as $k=>$v){
			$this->$k = $v;
		}
	}
}