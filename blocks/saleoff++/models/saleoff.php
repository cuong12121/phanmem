<?php 
class SaleoffBModelsSaleoff  extends FSModels
{
	function __construct()
	{
	}

	function setQuery($ordering,$limit,$type, $filter_category_auto = 0){
		$where = '';
		$order = '';	
		$select = '';	
		switch ($type){
			case 'hotest':
			$order .= ' ordering DESC,created_time DESC';
			$where .= '  AND is_hot = 1 ';	
			break;
			case 'viewest':
			$order .= ' hits DESC,created_time DESC';
			$where .= '';	
			break;
			case 'download':
			$order .= ' download DESC';
//				$where .= '  AND is_hot = 1 ';	
			break;
			case 'sale':
			$order .= ' sale DESC';
//				$where .= '  AND is_hot = 1 ';	
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

		$query = " SELECT * ".$select."
		FROM fs_products
		WHERE  published = 1 AND is_trash = 0 ".$where."
		ORDER BY  ".$order."
		LIMIT $limit  
		";
		return $query;
	}
	function get_list($ordering,$limit,$type, $filter_category_auto = 0){
		global $db;
		$query = $this->setQuery($ordering,$limit,$type,$filter_category_auto);
		if(!$query)
			return;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}	

	function get_list_product($sale_id) {
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT p.id, p.name , p.image , s.price, p.types ,s.price_old , p.alias, p.category_alias, p.category_id , p.is_new,  p.type, p.sale,p.quantity,p.is_hot,s.total_item_buy,s.total_item
		FROM " . $fs_table->getTable ( 'fs_sales_products' ) . " as s INNER JOIN ".$fs_table->getTable ( 'fs_products' ) ." as p ON s.product_id = p.id
		WHERE published = 1 AND sale_id = $sale_id
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}

	function get_types(){
		return $list = $this -> get_records('published = 1','fs_products_types','id,name,image,alias','ordering ASC');
	}

	function get_sale($type){
		$today_time = date('Y-m-d H:i:s');
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,name, finished_time,code_color
		FROM " . $fs_table->getTable ( 'fs_sales' ) . "
		WHERE is_default = 1 AND published = 1 AND started_time < '".$today_time ."' AND finished_time > '".$today_time."' AND type =".$type.  " ORDER BY ordering ASC";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}

	function get_sale_being($type){
		$today_time = date('Y-m-d H:i:s');
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,name,started_time
		FROM " . $fs_table->getTable ( 'fs_sales' ) . "
		WHERE is_default = 1 AND published = 1 AND started_time > '".$today_time ."' AND type =".$type.  " ORDER BY started_time ASC, ordering ASC";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}

	
}

?>