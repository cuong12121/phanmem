
<?php 
class HomeModelsHome extends FSModels
{
	function __construct()
	{
		$this->limit = 4;
	}

	function get_cats()
	{
		global $db;
		$query = " SELECT id,name, alias,tags_group,tablename,is_accessories, root_id, is_accessories,list_parents,icon,is_special,image,color,image,image_mb,limit_home
		FROM fs_products_categories 
		WHERE 
		show_in_homepage = 1
		ORDER BY ordering
		";
		$db->query($query);
		$list = $db->getObjectList();

		return $list;

	}
	function get_sub_cats($cat_id){

		return $this -> get_records('published = 1 AND is_show_home_subcat = 1 AND parent_id = '.$cat_id,'fs_products_categories','*',' ordering ASC ',1000);
	}

	function get_cats_lv2(){

		return $this -> get_records('published = 1 AND is_show_home_subcat = 1 AND level = 2','fs_products_categories','*',' ordering ASC ',1000);
	}

	function get_filter_manufactory($tablename) {
		$where = '';
		if ($tablename) {
			$where .= 'AND field_name = "manufactory" AND tablename = "' . $tablename . '"';
		}

		global $db;
		$query = ' SELECT filter_show,alias
		FROM fs_products_filters 
		WHERE published = 1  
		' . $where.'
		ORDER BY  ordering DESC LIMIT 12
		' ;
		$sql = $db->query ( $query );
		$list = $db->getObjectList ();

		return $list;
	}


	function get_manufactory($tablename) {
		$where = '';
		if ($tablename) {
			$where .= 'AND tablenames like "%,' . $tablename . ',%"';
		}

		global $db;
		$query = ' SELECT id,name,image,alias,icon
		FROM fs_manufactories 
		WHERE published = 1 AND show_in_homepage = 1 
		' . $where.'
		ORDER BY  ordering ASC LIMIT 6
		' ;
		$sql = $db->query ( $query );
		$alias = $db->getObjectList ();

		return $alias;
	}
		/*
		 * return products list in category list.
		 * These categories is Children of category_current
		 */
		function set_query_body($cat_id,$manf_id,$cat_special_id = 0)
		{
			$where  = "";
			
			if($cat_special_id){
				$where  .= " AND category_id_wrapper NOT like '%".$cat_special_id."%' ";
			}
			if($cat_id){
				$where  .= " AND category_id_wrapper like '%,".$cat_id.",%' ";
			}
			if($manf_id){
				$where  .= " AND manufactory =".$manf_id ;
			}
			$fs_table = FSFactory::getClass('fstable');
			$query = " FROM ".$fs_table -> getTable('fs_products')."
			WHERE 
			published = 1 AND is_trash = 0 AND category_published = 1 AND show_in_home = 1
			". $where.
			" ORDER BY  is_special DESC, ordering DESC
			";
						 // ORDER BY  ordering DESC,created_time DESC, id DESC
			return $query;
		}
		function get_list($query_body,$limit)
		{
			if(!$query_body)
				return;
			global $db;

			$query = " SELECT id,name,summary,image, created_time,category_id, category_alias, alias,price,price_old ,discount,published_double,image_double,date_end,date_start,warranty,types,style_types,is_hotdeal,type,gift,is_hot,name_core,name_display,status_special,name_special,image_hot,is_special,style_types,promotion_info,rate_sum, rate_count, status";
			$query .= $query_body;
			$query .= 'LIMIT '.$limit;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function get_types(){
			global $db;
			$query = "SELECT *
			FROM fs_products_types
			WHERE  published = 1
			ORDER BY ordering";
			if(!$query)
				return;
			$sql = $db->query($query);
			$result = $db->getObjectListByKey('id');
			return $result;
		}
		
		function get_cat_special(){
			return $this -> get_record('published = 1 AND is_special = 1','fs_products_categories');
		}
		function get_sub_cats_special($cat_id){
			return $this -> get_records('published = 1 AND parent_id = '.$cat_id,'fs_products_categories');
		}


		
	}
	
	?>