<?php 
class ProductsBModelsProducts  extends FSModels
{
	function __construct()
	{
	}

	function setQuery($cat_id,$ordering,$limit,$type, $filter_category_auto = 0){
		$where = '';
		$order = '';	
		$select = '';
		if($cat_id){
			$where = ' AND category_id_wrapper like "%,'.$cat_id.',%"';
		}	
		
		switch ($type){
			case 'is_hotdeal':
			$today_time = date('Y-m-d H:i:s');
			$order .= ' ordering DESC,created_time DESC';
			$where .= '  AND is_hotdeal = 1 and date_start <= "'.$today_time.'" AND date_end >= "'.$today_time.'"';	
			break;
			case 'viewest':
			$order .= ' hits DESC,created_time DESC';
			$where .= '';	
			break;
			case 'download':
			$order .= ' download DESC';
//				$where .= '  AND is_hot = 1 ';	
			break;
			case 'hot':
			$order .= ' is_hot DESC';
			$where .= '  AND is_hot = 1 ';	
			break;
			case 'discount':
			$order .= ' discount_rate DESC';				
			$select = ', (price_old - price)/price_old as discount_rate';	
			$where .= '  AND price_old > price';	
			break;
			case 'newest':
			$order .= ' created_time DESC,ordering DESC';
			break;	
			case 'random':
			$order .= ' RAND() ';
			break;	
			case 'in_cat':
			$ccode = FSInput::get('ccode');
			$id = FSInput::get('id');
			if($ccode)
				$where .= 'AND id <>'.$id.' AND category_alias_wrapper LIKE "%,'.$ccode.',%" ';
			$order .= ' ordering DESC,created_time DESC';
			break;

			case 'same_author':
			global $tmpl;
			$author_prd = $tmpl -> get_variables('author_prd');
			if(!$author_prd)
				return;
			$id = FSInput::get('id');
			$where .= 'AND id <>'.$id.' AND  user_id = '.$author_prd.'  ';
			$order .= ' ordering DESC,created_time DESC';
			break;
			default: 
			$order .= ' ordering DESC,created_time DESC';
			break;		
		}

		if($filter_category_auto){
			$view = FSInput::get('view');
			$module = FSInput::get('module');
			if($module == 'products' && $view == 'cat'){
				$id = FSInput::get('id');
				if($id)
					$where .= ' AND category_id_wrapper LIKE "%,'.$id.',%" ';
			}
			if($module == 'products' && $view == 'product'){
				$ccode = FSInput::get('ccode');
				if($ccode)
					$where .= ' AND category_alias_wrapper LIKE "%,'.$ccode.',%" ';
			}
		}

		$query = " SELECT id,name,summary,image, created_time,category_id, category_alias, alias,price,price_old ,discount,published_double,image_double,date_end,date_start,warranty,types,style_types,is_hotdeal,type,gift,is_hot,name_core,name_display,status_special,name_special,image_hot,is_special,style_types,promotion_info,rate_sum, rate_count,date_end, quantity, sale
		FROM fs_products
		WHERE  published = 1 AND is_trash=0 AND category_published = 1 ".$where."
		ORDER BY  ".$order."
		LIMIT $limit  
		";
		 //echo $query;
		// die();

		return $query;
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
	function get_list($cat_id,$ordering,$limit,$type, $filter_category_auto = 0){
		global $db;
		$query = $this->setQuery($cat_id,$ordering,$limit,$type,$filter_category_auto);
		if(!$query)
			return;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}	

	function get_cat($cat_id) {

		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,name,image, summary, alias
		FROM " . $fs_table->getTable ( 'fs_products_categories' )." WHERE id=".$cat_id;
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	// function get_types() {

	// 	$fs_table = FSFactory::getClass ( 'fstable' );
	// 	$query = " SELECT id,name,image
	// 	FROM " . $fs_table->getTable ( 'fs_products_types' );
	// 	global $db;
	// 	$sql = $db->query ( $query );
	// 	$result = $db->getObjectList ();
	// 	return $result;
	// }
}

?>