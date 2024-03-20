<?php 
class MembersModelsLevel extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 20;
		$this -> view = 'level';
		$this -> table_name = 'fs_members_level';
		parent::__construct();
	}

	function setQuery(){

			// ordering
		$ordering = "";
		$where = "  ";
		if(isset($_SESSION[$this -> prefix.'sort_field']))
		{
			$sort_field = $_SESSION[$this -> prefix.'sort_field'];
			$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
			$sort_direct = $sort_direct?$sort_direct:'asc';
			$ordering = '';
			if($sort_field)
				$ordering .= " ORDER BY $sort_field $sort_direct, id DESC ";
		}
		if(!$ordering)
			$ordering .= " ORDER BY ordering DESC , id DESC ";


		if(isset($_SESSION[$this -> prefix.'keysearch'] ))
		{
			if($_SESSION[$this -> prefix.'keysearch'] )
			{
				$keysearch = $_SESSION[$this -> prefix.'keysearch'];
				$where .= " AND ( a.name LIKE '%".$keysearch."%' )";
			}
		}
		$query = " SELECT a.*
		FROM 
		".$this -> table_name." AS a
		WHERE 1=1".
		$where.
		$ordering. " ";

		return $query;
	}

	function save($row = array(), $use_mysql_real_escape_string = 1){

		$level = FSInput::get('level');
		$is_default = FSInput::get('is_default');
		$published = FSInput::get('published');
		$row = array();

		if($is_default && $published) {
			$row2 = array();
			$row2['is_default'] = 0;
			$this-> _update($row2,'fs_members_level','1=1');
		}

		$checklist = $this-> get_record('published = 1','fs_members_level','id');
		if(empty($checklist)) {
			$row['is_default'] = 1;
		}

		$id = parent::save($row);

		if(!$level) {
			$row3 = array();
			$row3['level'] = $id;
			$this-> _update($row3,'fs_members_level','id = '.$id);
		}

		return $id;

	}


//		function get_total_member_for_training(){
//			$id = FSInput::get('id',0,'int');
//			if(!$id)
//				return 0;
//			$sql = " SELECT COUNT(*) as total
//				FROM fs_training_members 
//				WHERE training_id = $id
//					";
//			global $db ;
//			$db->query($sql);
//			return $rs =  $db->getResult();
//		}
}
?>