
<?php 
	class NewsModelsGuide
	{
		var $cat_parent_guide = 17; 
		function __construct()
		{
			$page = FSInput::get('page');
			$db = new Mysql_DB();
			
		}
		function getCategoriesGuide()
		{
			$cat_parent_guide = $this -> cat_parent_guide; // id of category "Use guide";
			$query = " SELECT id,name, image
						FROM fs_contents_categories 
						WHERE parent_id = $cat_parent_guide ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function getNewsListInCategory($catid)
		{
			global $db;
			$query = " SELECT id,title
						FROM fs_contents 
						WHERE categoryid = $catid ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		
	}
	
?>