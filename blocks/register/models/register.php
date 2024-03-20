<?php

class RegisterBModelsRegister extends FSModels
{
	function get_game(){
		return $this -> get_records('published = 1 ', 'fs_betting_games','*','ordering ASC ','20','id');
	}
}
?>