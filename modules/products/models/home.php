
<?php 
	class ProductsModelsHome
	function __construct()
	{
		var $limit_per_cat = 5;
		var $limit_cat = 5;
		parent::__construct ();
		global $module_config;
		FSFactory::include_class('parameters');
		$current_parameters = new Parameters($module_config->params);
		$limit   = $current_parameters->getParams('limit'); 
//		$limit =9;
			$this->limit_per_cat = 5;
		}
		
		/*
		 * select cat list is children of catid
		 */
		function getCats()
		{
			global $db;
			$query = " SELECT id,name, alias,tags_group,tablename,is_accessories, root_id, is_accessories,list_parents,icon
					FROM fs_products_categories 
					WHERE 
						show_in_homepage = 1
					ORDER BY ordering
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
			
			$order = " ORDER BY ordering DESC, id DESC ";
			$query   = " SELECT id,name,summary,image,price,quantity,alias ,category_alias,is_accessories ,is_new,is_hot,is_sale,promotion_info
						FROM fs_products 
						WHERE category_id_wrapper like '%".$cat_id."%' AND published = 1 "
						.$order." 
						LIMIT ".$this -> limit_per_cat." ";
						
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		
	}
	
?>