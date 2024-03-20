<?php 
	class RssModelsHome extends FSModels
	{
		function __construct()
		{
			parent::__construct();
			$this -> limit = 20;
		}
		
		function get_categories(){
			$limit_categories = 60;
			$query = " SELECT id, name, alias,level,parent_id,image
					  FROM fs_news_categories
					  WHERE published = 1
					ORDER BY  ordering ASC,id ASC
					 ";
			global $db;
			$sql = $db->query_limit($query,$limit_categories,$this->page);
			$list  = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($list);
			return $list;
		}
	}
?>