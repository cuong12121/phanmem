<?php 
	class AqModelsAq extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'aq';
			
			$this -> table_category_name = FSTable_ad::_ ('fs_aq_categories');
			$this -> table_types = FSTable_ad::_ ('fs_aq_types');
			$this -> arr_img_paths = array(array('resized',210,152,'resize_image'),array('small',80,80,'cut_image'));
			$this -> table_name = FSTable_ad::_ ('fs_aq');
			
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/aq/'.$cyear.'/'.$cmonth.'/'.$cday;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			// estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.category_id_wrapper like  "%,'.$filter.',%" ';
				}
			}	
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		function save($row = array(),$use_mysql_real_escape_string = 0){
			$title = FSInput::get('title');
			if(!$title)
				return false;
			$id = FSInput::get('id',0,'int');	
			$category_id = FSInput::get('category_id','int',0);
			if(!$category_id){
				Errors::_('Bạn phải chọn danh mục');
				return;
			}

			$products_category_id = FSInput::get ( 'products_category_id', array (), 'array' );
			$str_products_category_id = implode ( ',', $products_category_id );

			if($str_products_category_id) {
				$str_products_category_id = ',' . $str_products_category_id . ',';
			}
			$row ['products_category_id'] = implode(',',array_unique(explode(',', $str_products_category_id ))).',';


			
			$cat =  $this->get_record_by_id($category_id,$this -> table_category_name);
			$row['category_id_wrapper'] = $cat -> list_parents;
			$row['category_alias_wrapper'] = $cat -> alias_wrapper;
			$row['category_name'] = $cat -> name;
			$row['category_alias'] = $cat -> alias;
			$row['category_published'] = $cat -> published;
			
			$row['content'] = $_POST['content'];
			
			// related products
			$record_relate = FSInput::get('products_record_related',array(),'array');
			if(count($record_relate)){
				$record_relate = array_unique($record_relate);
				$row['products_related'] = ','.implode(',', $record_relate).',';	
	//			$this -> sys_related('fs_products','products_related',$row['products_related'],$id);
			}	
			return parent::save($row);
		}
		
		/*
		 * select in category of home
		 */
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_category_name." AS a
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
		
		/*
	     * Save all record for list form
	     */
	    function save_all(){
	        $total = FSInput::get('total',0,'int');
	        if(!$total)
	           return true;
	        $field_change = FSInput::get('field_change');
	        if(!$field_change)
	           return false;
	        $field_change_arr = explode(',',$field_change);
	        $total_field_change = count($field_change_arr);
	        $record_change_success = 0;
	        for($i = 0; $i < $total; $i ++){
//	        	$str_update = '';
	        	$row = array();
	        	$update = 0;
	        	foreach($field_change_arr as $field_item){
	        	      $field_value_original = FSInput::get($field_item.'_'.$i.'_original')	;
	        	      $field_value_advice = FSInput::get($field_item.'_'.$i)	;
	        		  if(is_array($field_value_advice)){
        	      		$field_value_advice = count($field_value_advice)?','.implode(',',$field_value_advice).',':'';
	        	      }
	        	      
	        	      if($field_value_original != $field_value_advice){
	        	          $update =1;
	        	       		// category
	        	          if($field_item == 'category_id'){
	        	          		$cat =  $this->get_record_by_id($field_value_advice,$this -> table_category_name);
								$row['category_id_wrapper'] = $cat -> list_parents;
								$row['category_alias_wrapper'] = $cat -> alias_wrapper;
								$row['category_name'] = $cat -> name;
								$row['category_alias'] = $cat -> alias;
								$row['category_published'] = $cat -> published;
								$row['category_id'] = $field_value_advice;
	        	          }else{
								$row[$field_item] = $field_value_advice;
	        	          }
	        	      }    
	        	}
	        	if($update){
	        		$id = FSInput::get('id_'.$i, 0, 'int'); 
	        		$str_update = '';
	        		global $db;
	        		$j = 0;
	        		foreach($row as $key => $value){
	        			if($j > 0)
	        				$str_update .= ',';
	        			$str_update .= "`".$key."` = '".$value."'";
	        			$j++;
	        		}
            
		            $sql = ' UPDATE  '.$this ->  table_name . ' SET ';
		            $sql .=  $str_update;
		            $sql .=  ' WHERE id =    '.$id.' ';
		            $db->query($sql);
		            $rows = $db->affected_rows();
		            if(!$rows)
		                return false;
		            $record_change_success ++;
	        	}
	        }
	        return $record_change_success;  
	           
	}
	/*
	 *====================AJAX RELATED PRODUCTS==============================
	 */
	function get_products_related($products_related){
		if(!$products_related)
				return;
		$query   = " SELECT id, name 
					FROM ".FSTable_ad::_ ('fs_products')."
					WHERE id IN (0".$products_related."0) 
					 ORDER BY POSITION(','+id+',' IN '0".$products_related."0')
					";
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	
	/*
		 * select in category
		 */
	function get_products_categories_tree() {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
				FROM ".FSTable_ad::_ ('fs_products_categories')." WHERE level = 0" ;
		$db->query ( $sql );
		$categories = $db->getObjectList ();
		
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$rs = $tree->indentRows ( $categories, 1 );
		return $rs;
	}
	function ajax_get_products_related(){
		$category_id = FSInput::get('category_id',0,'int');
		$keyword = FSInput::get('keyword');
		$where = ' WHERE published = 1 ';
		if($category_id){
			$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
		}
		$where .= " AND ( name LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' )";
		
		$query_body = ' FROM '.FSTable_ad::_ ('fs_products').' '.$where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT id,category_id,name,category_name '.$query_body.$ordering.' LIMIT 40 ';
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	/*
	 *====================AJAX RELATED PRODUCTS end.==============================
	 */
}
?>