<?php 
	class MenusModelsItems extends FSModels
	{
		var $limit;
		var $page;
		var $prefix ;
		function __construct()
		{
			$limit = 170;
			$limit_created_link = 30;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->limit_created_link = $limit_created_link;
			$this->page = $page;
			$this -> view = 'items';
			$this -> table_name = FSTable_ad::_('fs_menus_items');
			$this -> table_link = 'fs_menus_createlink';
			$this -> arr_img_paths_menu = array(array('resized',230,340,'cut_image'));
			parent::__construct();
			// config for save
	
			$this->img_folder = 'images/menus';
			parent::__construct();
		}
		
		function getMenuItems()
		{
			// get from database
			global $db;
			$query = $this->setQuery();
			$db->query($query);
			$result = $db->getObjectList();
			
			// create tree
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			
			$limit = $this->limit;
			$page  = $this->page?$this->page:1;
			
			$start = $limit*($page-1);
			$end = $start + $limit;
			
			$list_new = array();
			$i = 0;
			foreach ($list as $row){
				if($i >= $start && $i < $end){
					$list_new[] = $row;
				}
				$i ++;
				if($i > $end)
					break;
			}
			return $list_new;
			
			
			
			
//			$sql = $db->query_limit($query,$this->limit,$this->page);
//			$result = $db->getObjectList();
//			
//			return $result;
		}
		
		function getMenuGroups()
		{
			global $db;
			$query = " SELECT group_name, id 
						FROM fs_menus_groups ";
			$result = $db->getObjectList($query);


			return $result;
		}

		function get_cat_banner()
		{
			global $db;
			$query = " SELECT id, name 
						FROM fs_banners_categories 
						WHERE published = 1 AND is_menu = 1;
				";
			$result = $db->getObjectList($query);

				
			return $result;
		}
		
		function getMenuItemsToParent($group_id = 0)
		{
			global $db;
			$where = '';
			if($group_id)
				$where .= ' AND group_id = '.$group_id.' ';
			$query = " SELECT name, id, parent_id as parent_id 
						FROM ".$this -> table_name."
						WHERE (show_admin = 1 OR group_id IS NOT NULL) ".$where." ";

			$result = $db->getObjectList($query);
			
			$fs_tree  = FSFactory::getClass('tree','tree');
			$list = $fs_tree -> indentRows($result);
			return $list;
			
		}
		
		function ajax_get_menu_by_group()
		{
			$group_id = FSInput::get('group_id');
			$filter_group = FSInput::get('filter_group');
			global $db;
			$where = '';
			if($group_id && $filter_group)
				$where .= ' AND group_id = '.$group_id.' ';
			$query = " SELECT name, id, parent_id as parent_id 
						FROM ".$this -> table_name."
						WHERE (show_admin = 1 OR group_id IS NOT NULL) ".$where." ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$fs_tree  = FSFactory::getClass('tree','tree');
			$list = $fs_tree -> indentRows($result);
			array_unshift($list,(object)array('id'=>0,'name'=>FSText::_('Parent'),'treename'=>FSText::_('Parent'),'parent_id'=>0));
			return $list;
		}
		
		function setQuery()
		{
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct,a.parent_id, created_time DESC, id DESC ";
			}
			if(!$ordering)
			$ordering .= " ORDER BY ordering ASC,created_time DESC , id DESC ";
		
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
				// estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND group_id =  "'.$filter.'" ';
				}
			}	
				
			$gid = FSInput::get('gid');
//			$where = " WHERE  show_admin = 1 OR group_id IS NOT NULL ";
//			if($gid)
//				$where .= "  AND = $gid ";
		$query = " SELECT a.*, parent_id as parent_id, b.group_name 
						  FROM ".$this -> table_name." as a
						  LEFT JOIN fs_menus_groups as b ON a.group_id  = b.id 
						  WHERE  (show_admin = 1 OR group_id IS NOT NULL)  ".
						 $where.
						 $ordering ." ";
			return $query;
		}
		
	
		function getMenuItemById($id)
		{
			$query = " SELECT *
						  FROM ".$this -> table_name."
						  WHERE id = $id ";
			
			global $db;
			$result = $db->getObject($query);
			return $result;
		}
		
		/*
		 * Save
		 */

		function save($row = array(), $use_mysql_real_escape_string = 1)
		{
			global $db;
			$id = FSInput::get('id',0,'int');
			$parent_id= FSInput::get('parent_id',0,'int');
			if($id){
				if($parent_id == $id){
					Errors::_('Parent is not exactly');	
					return false;
				}
			}
			$name= FSInput::get('name');
			$alias = FSInput::get('alias');
			
			if(!$name){
				return false;
			}
			
			$fsstring = FSFactory::getClass('FSString','','../');
			if($alias){
			     $alias = $fsstring -> stringStandart($alias);	
			} else {
				$alias = $fsstring -> stringStandart($name);   
			}
//			if($this -> check_exist_alias($name,$alias,$id, $this -> table_name)){
//				Errors::_('Name must unique');
//				return false;
//			}
			
			$description = FSInput::get('description');
			$group_id = FSInput::get('group_id');
			$published = FSInput::get('published');
			$show_hot = FSInput::get('show_hot');
			$show_dot = FSInput::get('show_dot');
			$ordering = FSInput::get('ordering');
			$target  = FSInput::get('target');
			$is_mobile  = FSInput::get('is_mobile');
			$is_en  = FSInput::get('is_en');
			$icon  = FSInput::get('icon');
			$link = htmlspecialchars_decode(FSInput::get('link'));
			$nofollow  = FSInput::get('nofollow');
			
			
			$default = FSInput::get('default',0,'int');
			$time = date('Y-m-d H:i:s');
			$show_admin = 1;

			$banner_id = FSInput::get('banner_id',0,'int');
				
			// image
			$image = $_FILES["image"]["name"];
			$sql_insert_img_field ="";   
			$sql_insert_img_value ="";

			$sql_insert_parent_id_field = isset($parent_id)? "parent_id,":"";   
			$sql_insert_parent_id_value = isset($parent_id)? "'".$parent_id."',":"";
			$sql_update_parent_id = isset($parent_id)? "parent_id = '".$parent_id."', ":"";

			$sql_insert_default_field = isset($default)? "`default`,":"";  
			$sql_insert_default_value = isset($default)? "'".$default."',":"";
			$sql_update_default = isset($parent_id)? "`default` = '".$default."', ":"";

			// $sql_update_img =" ";
			// if($image){
			// 	$fsFile = FSFactory::getClass('FsFiles');
			// 	$path = PATH_BASE.'images'.DS.'menus'.DS;
			// 	$image = $fsFile -> uploadImage("image", $path ,2000000, '_'.time());
			// 	if(!$image)
			// 		return false;
					
			// 	$sql_insert_img_field ="image,";   
			// 	$sql_insert_img_value ="'images/menus/".$image."',";   
				
			// 	$sql_update_img = "image = 'images/menus/".$image."', ";
			// }

			// images hover
			$image_name_menu = $_FILES["image"]["name"];

			if($image_name_menu){
				$image_menu = $this->upload_image('image','_'.time(),2000000,$this -> arr_img_paths_menu);
				if($image_menu){
					
					$sql_insert_img_field ="image,";   
					$sql_insert_img_value = "'".$image_menu."',";   
					$sql_update_img = "image ='".$image_menu."',";
				}
			}
			
			if(@$id)
			{
				if(!$parent_id){
					$level = 0;
					$list_parent = $id;
				} else {
					$parent_item = $this -> getMenuItemById($parent_id);
					$level = ($parent_item -> level + 1);
					$list_parent = $parent_item -> list_parent . ",".$id;
				}
				
				$sql = " UPDATE  ".$this -> table_name." SET 
							name = '$name',
							alias = '$alias',
							description = '$description',
							link = '$link',
							".$sql_update_parent_id."
							".$sql_update_img." 
							group_id = '$group_id',
							published = '$published',
							show_hot = '$show_hot',
							show_dot = '$show_dot',
							ordering = '$ordering',
							target = '$target',
							nofollow = '$nofollow',
							show_admin = '$show_admin',
							".$sql_update_default."
							updated_time = '$time',
							list_parent = '$list_parent',
							level = '$level',
							icon = '$icon',
							is_mobile = '$is_mobile',
							banner_id = ".$banner_id."
							WHERE id = 	$id 
				";
				// print_r($sql);die;
				$rows = $db->affected_rows($sql);
				if($rows)
				{
					return $id;
				}
				return 0;
			}
			else
			{
				$sql = " INSERT INTO ".$this -> table_name."
							(name,nofollow,alias,".$sql_insert_img_field."link,".$sql_insert_parent_id_field."group_id,published,ordering,target,show_admin,".$sql_insert_default_field."updated_time,created_time,icon,is_mobile,banner_id)
							VALUES ('$name','$nofollow','$alias',".$sql_insert_img_value."'$link',".$sql_insert_parent_id_value."'$group_id','$published','$ordering','$target','$show_admin',".$sql_insert_default_value."'$time','$time','$icon','$is_mobile','$banner_id')
							";
				//print_r($sql);die;			
				$id = $db->insert($sql);
				if(!$id)
					return;
					
				if(!$parent_id){
					$level = 0;
					$list_parent = $id;
				} else {
					$parent_item = $this -> getMenuItemById($parent_id);
					$level = ($parent_item -> level + 1);
					$list_parent = $parent_item -> list_parent . ",".$id;
				}
				
				// update list_parent
				$sql = " UPDATE  ".$this -> table_name." SET 
							list_parent = '$list_parent',
							level = '$level'
							WHERE id = ".$id." ";
				$rows = $db->affected_rows($sql);
				
				return $id;
			}
			
		}
		
		/*
		 * remove record
		 */
//		}
		/*********************************** CREATE LINK *********************************/

		function getCreateLinks()
		{
			global $db;
			$query = " SELECT *, parent_id as parent_id
						FROM  ".$this -> table_link."
						WHERE published = 1 
						ORDER BY parent_id, ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			foreach($result as $item){
				$item -> name = FSText::_($item -> name);
			}
			
			$fs_tree  = FSFactory::getClass('tree','tree');
			$list = $fs_tree -> indentRows($result);
			return $list;
		}
		
		function getParentLink()
		{
			global $db;
			$query = " SELECT parent, count(*) as nums_child
						FROM  ".$this -> table_link."						 
						WHERE 	 published = 1	
						GROUP BY parent ";
			$result = $db->getObjectList($sql);
			
			return $result;
		}
		
		function get_linked_id()
		{
			$id = FSInput::get('id',0,'int');
			if(!$id)
				return;
			global $db;
			$query = " SELECT *
						FROM  ".$this -> table_link."
						WHERE published = 1
						AND id = $id 
						 ";
			$result = $db->getObject($query);
			
			return $result;
		}
		
		
		function set_query_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct){
			$query  = '';
			$where ='';
			if(isset($_SESSION['menu_ceate_link']) AND !empty($_SESSION['menu_ceate_link'])){
				$where .=' AND '.$add_field_display.' like "%'.$_SESSION['menu_ceate_link'].'%" ';
			}
			if($add_field_distinct){
				if($add_field_display != $add_field_value){
					echo "Khi đã chọn distinct, duy nhất chỉ xét một trường. Bạn hãy check lại trường hiển thị và trường dữ liệu";
					return false;
				}
				$query .= ' SELECT DISTINCT '.$add_field_display. ' ';
			} else {
				$query .= ' SELECT '.$add_field_display. ' ,' . $add_field_value.'  ';
			}
			$query .= ' FROM '.$add_table ;
			$query .= '	WHERE published = 1 ' . $where;

			return $query;
		}
		/*
		 * get List data from table
		 * for create link
		 */
		function get_data_from_table($add_table,$add_field_display,$add_field_value,$add_field_distinct){
			$query = $this -> set_query_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct);
			if(!$query)
				return;
			
			
			global $db;
			$sql = $db->query_limit($query,$this->limit_created_link,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function get_total_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct){
			global $db;
			$query = $this -> set_query_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct);

			$total = $db->getTotal($query);
			return $total;
		}
		
		function get_pagination_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct)
		{
			$total = $this->get_total_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct);		
			$pagination = new Pagination($this->limit_created_link,$total,$this->page);
			return $pagination;
		}
		
		/*********************************** end CREATE LINK *********************************/		 
	}
	
?>