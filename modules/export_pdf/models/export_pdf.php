
<?php 
	class Export_pdfModelsExport_pdf extends FSModels
	{
		function __construct()
		{
			$this->limit = 8;
		}
		function get_cats()
		{
			global $db;
			$query = " SELECT id,name, alias,tags_group,tablename,is_accessories, root_id, is_accessories,list_parents
					FROM fs_products_categories 
					WHERE 
						show_in_homepage = 1 
					ORDER BY id ASC
							";
			$db->query($query);
			$list = $db->getObjectList();

			
			return $list;	
		}
		
		function get_data_for_export_ajax(){
			global $db;
			$ordering = "";
			$where = "  ";
			$query = " SELECT a.product_id,a.count FROM fs_built_items AS a WHERE 1=1 " . $where . " " ;
			$sql = $db->query ( $query );
			$result = $db->getObjectList();
			return $result;
		}
		
		/*
		 * return products list in category list.
		 * These categories is Children of category_current
		 */
		function set_query_body($cat_id)
		{

			$where  = "";
			if(!$cat_id){
				$cat_id =1959;
			}
			if($cat_id>0){
				$where  .= " AND category_id_wrapper like '%".$cat_id."%' ";
			}
			
			$fs_table = FSFactory::getClass('fstable');
			$query = " FROM ".$fs_table -> getTable('fs_products')."
						  WHERE 
						  	 published = 1  AND category_published = 1 AND show_in_home = 1
						  	". $where.
						    " ORDER BY  ordering DESC,created_time DESC, id DESC
						 ";
			return $query;
		}
		function get_list($query_body)
		{
			if(!$query_body)
				return;
			global $db;
			$query = " SELECT id,name,alias,category_alias,category_id ,image,price,price_old,quantity,alias,discount,types,is_hot,is_new,style_types,type";
			$query .= $query_body;
			$query .= 'LIMIT '.$this->limit;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function get_types(){
			global $db;
				$query = "SELECT id,name,image,alias
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