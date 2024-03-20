
<?php 
	class ProductsModelsCombo extends FSModels{

	
	var $limit_cat = 10;

	function __construct(){
		
		parent::__construct ();
		global $module_config;
		FSFactory::include_class('parameters');
		$current_parameters = new Parameters(@$module_config->params);
		$limit   = $current_parameters->getParams('limit'); 
//		$limit =9;
			$this->limit_per_cat = 10;
		}
		
		/*
		 * select cat list is children of catid
		 */
		function getCats()
		{
			global $db;
			$fstable = FSFactory::getClass('fstable');
			$table_name  = $fstable->_('fs_products_categories');
		    $query = " SELECT id,name, alias,tags_group,tablename,root_id, list_parents,image,level,parent_id,count_combo_home
					FROM ".$table_name."
					WHERE 
						is_combo = 1
					ORDER BY ordering ASC
							";
			$db->query($query);
			$list = $db->getObjectList();
			
			return $list;	
		}
		
		/*
		 * select Relate cats
		 */
		function get_cats_relates($str_cats_rootid)
		{
			if(!$str_cats_rootid)
				return false;
			
			global $db;
			$query = " SELECT id ,parent_id, root_id, name, image,icon, root_alias
					FROM fs_products_categories 
					WHERE 
						root_id IN ($str_cats_rootid)
							";
			$db->query($query);
			$list = $db->getObjectList();
			
			return $list;	
		}
		
		/*
		 * return products list in category list.
		 * These categories is Children of category_current
		 */
		function getProducts($cat_id)
		{
			global $db;
			if(!$cat_id)
				return false;
			$fstable = FSFactory::getClass('fstable');
			$table_name  = $fstable->_('fs_products');
			$order = " ORDER BY ordering DESC, id DESC ";
			$query   = " SELECT id,name,alias,category_alias,category_id ,image,price,price_old,quantity,alias,discount,types,is_hot,is_new,style_types,type
						FROM ".$table_name." 
						WHERE category_id_wrapper like '%,".$cat_id.",%' AND published = 1 AND is_trash = 0 AND is_combo = 1"
						.$order." 
						LIMIT ".$this -> limit_per_cat." ";
						
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		function get_types(){
			global $db;
				$query = "SELECT id,name
					 FROM fs_products_types
					 WHERE  published = 1

					 ORDER BY ordering
				";
			if(!$query)
				return;
			$sql = $db->query($query);
			$result = $db->getObjectListByKey('id');
			return $result;
		}
		
	}
	
?>