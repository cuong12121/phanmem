<?php
	
	class MenusControllersItems extends Controllers
	{
		var $module;
		var $gid;
		function __construct()
		{
			$this->view = 'items' ; 
			$this->gid = FSInput::get('gid');
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
						 
			$list = $model->getMenuItems();
			$groups = $model->getMenuGroups();

			$cat_banner = $model->get_cat_banner();

			$pagination = $model->getPagination('');
			

			// call views
			
			include 'modules/'.$this->module.'/views/items/list.php';
		}
		
		function getMenuItems()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function add()
		{
			$model  = $this -> model;
			$create_link = $model -> getCreateLinks();
			$list = $model->getMenuItemsToParent();
			$groups = $model->getMenuGroups();
			$cat_banner = $model->get_cat_banner();
			$maxOrdering = $model->getMaxOrdering();
			include 'modules/'.$this->module.'/views/items/detail.php';
		}
		function edit()
		{
			$model  = $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			$create_link = $model -> getCreateLinks();
			$list = $model->getMenuItemsToParent($data -> group_id );
			$groups = $model->getMenuGroups();
			$cat_banner = $model->get_cat_banner();
			include 'modules/'.$this->module.'/views/items/detail.php';
		}
		function ajax_get_menu_by_group(){
			$model  = $this -> model;
			$rs  = $model -> ajax_get_menu_by_group();
			
			$json = '['; // start the json array element
			$json_names = array();

			foreach( $rs as $item)
			{
				$json_names[] = "{id: $item->id, name: '$item->treename'}";
			}
			$json .= implode(',', $json_names);
			$json .= ']'; // end the json array element
			echo $json;
		}
		
		/*********************************** CREATE LINK *********************************/

		function add_param(){
			$model  = $this -> model;
			$created_link  = $model -> get_linked_id();
			if(!$created_link)
				return;
			
			$field_display  = $created_link -> add_field_display;
			$field_value  = $created_link -> add_field_value;
			$add_param  = $created_link -> add_parameter;
			
			// create array if add multi param
			$arr_field_value = explode(',',$field_value);
			$arr_add_param = explode(',',$add_param);
			
			
			$list = $model->get_data_from_table($created_link -> add_table,$field_display,$field_value,$created_link -> add_field_distinct);
			$pagination = $model->get_pagination_create_link($created_link -> add_table,$field_display,$field_value,$created_link -> add_field_distinct);
			include 'modules/'.$this->module.'/views/items/add_param.php';
		}


		function ajax_set_seetion_search(){
			$key = FSInput::get('key');
			$_SESSION['menu_ceate_link']  =  $key ;
			echo 1;
			return;
		}

		function ajax_reset_seetion_search(){
			unset($_SESSION['menu_ceate_link']);
			echo 1;
			return;
		}
//		function linked()
//		{
//			$model = new MenusModelsItems();
//			$linked_list = $model->getCreateLink();
//			$parent_list = $model->getParentLink();
//			
//			$cid = FSInput::get('cid');
//			if($cid)
//			{
//				$linked = $model -> getLinkedById($cid);
//			}
//			include 'modules/'.$this->module.'/views/items/linked.php';
//			
//		}
		/*********************************** end CREATE LINK *********************************/		 
	}
	
?>