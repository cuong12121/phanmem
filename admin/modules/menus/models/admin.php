
<?php 
	class MenusModelsAdmin
	{
		function __construct()
		{
		}
		
		function setQuery()
		{
			$group_data = $this->get_group_data();
			$arr_per_md = array();
			$arr_per_view = array();
			if(!empty($group_data->str_task)){
				$group_per_md = $this->get_group_module($group_data->str_task);
				if(!empty($group_per_md)){
					foreach ($group_per_md as $group_per_md_it) {
						$arr_per_md[$group_per_md_it-> module] =  $group_per_md_it-> module;
						// $arr_per_view[$group_per_md_it-> view] =  $group_per_md_it-> view;
					}
				}
			}

			//tìm module
			$arr_per_md = array_unique($arr_per_md);
			$str_per_md = "";
			foreach ($arr_per_md as $per_md) {
				$str_per_md .= '"'.$per_md.'",';
			}
	
			$str_per_md .= '"home"';
			$where='';

			//tìm vieww
			//làm sau

			
			if($_SESSION['ad_groupid'] == 4 || $_SESSION['ad_userid'] == 9 || $_SESSION['ad_userid'] == 6){
           
	        }else{
	           $where .= ' AND module IN ('.$str_per_md.')';
	        }

			$query = " SELECT *, parent_id as parent_id
						  FROM fs_menus_admin
						  WHERE published = 1
						  ".$where."
						  ORDER BY ordering 
						 ";
			return $query;
		}
		
		
		function getMenusAdmin()
		{
			global $db;
			$query = $this->setQuery();
			$result = $db->getObjectList($query);
			
			return $result;
		}
		
		function user_permission(){
			if(!isset($_SESSION['ad_userid']))
				return false;
			global $db;
			$user_id = $_SESSION['ad_userid'];
			
			// get groupid
			$query = ' SELECT a.permission,b.module ,b.view 
						FROM fs_users_permission AS a 
						INNER JOIN fs_permission_tasks  AS b ON a.task_id = b.id
						WHERE user_id = '.$user_id.'
					';

			$result = $db->getObjectList($query);
			
			$array_permission = array();
			for($i = 0 ; $i < count($result); $i ++ ){
				$array_permission[$result[$i]->module][$result[$i]->view] = $result[$i]->permission;
			}

			// printr($array_permission);
			return $array_permission;
		}

		function get_group_data(){
			global $db;
			$sql2 = 'SELECT * FROM fs_users_groups WHERE id = '.$_SESSION['ad_groupid'];
			$group_data = $db->getObject($sql2);
			return $group_data;
		}

		function get_group_module($str){

			$str = substr($str,1,-1);
		
			global $db;
			$sql2 = 'SELECT * FROM fs_permission_tasks WHERE id IN ('.$str.')';
			$rs = $db->getObjectList($sql2);
			return $rs;
		}
		
		
	}
	
?>