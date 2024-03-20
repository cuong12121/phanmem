<?php 
class DepartmentModelsDepartment extends FSModels
{
	function __construct()
	{
		parent::__construct();
		$this->limit = 200;
	}
	function set_query_body()
	{
		$id  = FSInput::get("city_id",0,'int');
		$where  = "";
		if($id){
			$_SESSION["city"]=$id;
		}
		$city_id = isset($_SESSION["city"])?$_SESSION["city"]:$id;
		if($city_id){
			$where.=" and region_id=".$city_id;
		}

		$district = isset($_SESSION["district"])?$_SESSION["district"]:0;
		if($district){
			$where.=" and district=".$district;
		}
		$fs_table = FSFactory::getClass('fstable');
		 $query = " FROM ".$fs_table -> getTable('fs_address')."
		WHERE  published = 1
		". $where.
		" ORDER BY  ordering ASC, id DESC
		";
						// echo $query;
		return $query;
	}

	function get_regions(){
		return $this -> get_records('published  = 1','fs_address_regions','id,name',' ordering ASC, id ASC ');
	}
	
	
		/*
		 * get Category current
		 * By Id or By code
		 */
		function get_category()
		{
			$fs_table = FSFactory::getClass('fstable');
			$code = FSInput::get('ccode');
			if($code){
				$where = " AND alias = '$code' ";
			} else {
				$id = FSInput::get('id',0,'int');
				if(!$id)
					die('Not exist this url');
				$where = " AND id = '$id' ";
			}
			$query = " SELECT *
			FROM ".$fs_table -> getTable('fs_faq_categories')." 
			WHERE published = 1 ".$where;
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		function get_info_other()
		{
			$fs_table = FSFactory::getClass('fstable');
			$query = " SELECT *
			FROM ".$fs_table -> getTable('fs_address_other')." 
			";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function get_list($query_body)
		{
			if(!$query_body)
				return;
			
			global $db;
			$query = " SELECT * ";
			$query .= $query_body;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function getTotal($query_body)
		{
			if(!$query_body)
				return ;
			global $db;
			$query = "SELECT count(*)";
			$query .= $query_body;
			$sql = $db->query($query);
			$total = $db->getResult();
			return $total;
		}
		
		function getPagination($total)
		{
			FSFactory::include_class('Pagination');
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
		
		function get_categories_tree()
		{
			global $db;
			$id  = FSInput::get("city_id");
			$where  = "";
			if(isset($_SESSION["city"])){
				$where.=" and provinceid=".$_SESSION["city"];
			}
			$query = " SELECT DISTINCT p.* from fs_address a INNER JOIN district p on a.district=p.id where 1=1 $where order by a.alias asc
			";
			//	echo $query;			
			$sql = $db->query($query);
			$result = $db->getObjectList();
			// $tree  = FSFactory::getClass('tree','tree/');
			// $list = $tree -> indentRows2($result);
			return $result;
		}
		function get_city(){
			global $db;
			$query = " SELECT DISTINCT p.* from fs_address a INNER JOIN province p on a.province=p.id
			
			ORDER BY alias asc ";
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
		function getListDistricts($city_id = 0){
			global $db;
			$sqlWhere = '';
			if($_SESSION["city"]){
				$sqlWhere.=" and provinceid=".$_SESSION["city"];
			}
			if($city_id)
				$sqlWhere = ' AND provinceid = "'.$city_id.'"';
			$query = '  SELECT id, name,alias
			FROM district 
			WHERE published = 1 '.$sqlWhere.'
			ORDER BY alias ASC';
//                        echo $query;die;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
	}
	
	?>