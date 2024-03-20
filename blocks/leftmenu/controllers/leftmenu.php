<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/leftmenu/models/leftmenu.php';
	
	class LeftMenuBControllersLeftMenu
	{
		function __construct()
		{
		}
		function display($parameters,$title){
			$group = $parameters->getParams('group');
			$style = $parameters->getParams('style');
			$style = $style?$style:'default';
			if(!$group)	
				return;
			// call models
			$model = new LeftMenuBModelsLeftMenu();
			$order_to_tree = 1;
			if($style == 'phunutoday')
				$order_to_tree = 0;
			$list = $model->getList($group,$order_to_tree);
			if(!$list)
				return;
			$array_menu_root = array(); 
			$array_menu_children = array(); 
			$parent_active = 0;
			$id_active = 0;
			foreach($list as $item){
				if(!$item -> parent_id){
					$array_menu_root[] = $item;
					if($this -> check_active($item -> link)){
						$parent_active = $item -> id;
						$id_active = $item -> id;
					}
				}else{
					if(!isset($array_menu_children[$item -> parent_id]))
						$array_menu_children[$item -> parent_id] = array();
					$array_menu_children[$item -> parent_id][] = $item;	
					if($this -> check_active($item -> link)){
						$parent_active = $item -> parent_id;
						$id_active = $item -> id;
					}
				}
			}	
			// call views
			include 'blocks/leftmenu/views/leftmenu/'.$style.'.php';
		}

		/*
		 * Check acvited for link menu
		 */
		function check_active($link=''){
			$link_rewrite = FSRoute::_($link)."--";
			$url_current = URL_ROOT.substr($_SERVER['REQUEST_URI'],1);
			
			if($link_rewrite == $url_current)
				return true;
			$module = FSInput::get('module');
			$view = FSInput::get('view');
			if($module == 'news' && ($view=='news' || $view == 'cat')){
				$ccode = FSInput::get('ccode');
				if(strpos($link,'&ccode='.$ccode ) !== false){
					return true;
				}
			}
			return false;
		}
	}
	
?>