<?php 
class LandingpagesModelsLandingpages extends FSModels
{
	function __construct()
	{
		$limit = 2;
		$page = FSInput::get('page');
		$this->limit = $limit;
		$this->page = $page;
		$fstable = FSFactory::getClass('fstable');
		$this->table_name  = $fstable->_('fs_landingpages');
	}
	function getContents()
	{
		$id = FSInput::get('id',0,'int');
		if($id){
			$where = " AND id = '$id' ";				
		} else {
			$code = FSInput::get('code');
			if(!$code)
				die('Not exist this url');
			$where = " AND alias = '$code' ";
		}
		$fs_table = FSFactory::getClass('fstable');
		$query = " SELECT id,title,content,alias, html, css, js
		FROM ".$fs_table -> getTable('fs_landingpages')." 
		WHERE published = 1
		".$where." ";
		global $db;
		$sql = $db->query($query);
		$result = $db->getObject();
		return $result;
	}


}

?>