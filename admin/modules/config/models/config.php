<?php 
class ConfigModelsConfig   extends FSModels
{

	function __construct()
	{
		parent::__construct();
		$this -> name_table = FSTable_ad::_('fs_config');
		$this -> name_table_group = FSTable_ad::_('fs_config_groups');
	}

	function getData()
	{
		global $db;
		$query = $this->setQuery();
		if(!$query)
			return array();

		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}

	function getGroup() {
		global $db;
		$query = "SELECT *
		FROM 
		". $this -> name_table_group ."
		WHERE published = 1
		ORDER BY ordering ASC, id ASC ";
		if(!$query)
			return array();

		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}


	function getDataOfGroup($groupid){
		global $db;
		// $query = $this->setQuery();
				$query = " SELECT *
		FROM 
		". $this -> name_table ."
		WHERE published = 1 AND group_id = ".$groupid."
		ORDER BY ordering ASC, id ASC 
		";
		if(!$query)
			return array();

		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}

	function getDataOfGroupOther(){
		global $db;
		// $query = $this->setQuery();
		$query = " SELECT *
		FROM 
		". $this -> name_table ."
		WHERE published = 1 AND group_id = 0
		ORDER BY ordering ASC, id ASC 
		";
		if(!$query)
			return array();

		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}


	function setQuery()
	{
		$query = " SELECT *
		FROM 
		". $this -> name_table ."
		WHERE published = 1
		ORDER BY ordering ASC, id ASC 
		";

		return $query;
	}

		/*
		 * 
		 * Save
		 */
		function save($row = array(),$use_mysql_real_escape_string = 0)
		{
			$data = $this->getData();
			$fsFile = FSFactory::getClass('FsFiles');
			global $db;
			
			foreach($data as $item)
			{
				if($item->data_type == 'editor')
					$value =htmlspecialchars_decode(FSInput::get("$item->name"));
				else if($item->data_type == 'image'){
					if(isset($_FILES[$item->name]['name']) && !empty($_FILES[$item->name]['name'])){
						$path = PATH_BASE.'images'.DS.'config'.DS;
						$image = $fsFile -> uploadImage($item->name, $path,2000000,'_'.time());
						if(!$image)	
							continue;
						$value = 'images/config/'.$image;
					}else{
						continue;
					}
				}else if($item->data_type == 'text'){
					$value =FSInput::get("$item->name");
				}else{
					$value = $db -> escape_string($_REQUEST["$item->name"]);
					//$value = htmlspecialchars_decode($_REQUEST["$item->name"]);
				}

				
				$sql = " UPDATE fs_config SET 
				value = '$value'
				WHERE name = '$item->name' ";
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
			}
			return true;
			
		}
		
		
	}
	
	?>