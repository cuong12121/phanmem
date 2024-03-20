
<?php 
	class ProductsModelsCompare  extends FSModels {
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 12;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->table_name = 'fs_products';
		}
		
		function get_product_by_id($id){
			if(!$id)
				return;
			return $this -> get_record('id = '.$id.' AND published = 1','fs_products');
		}
		
		function getProducts($tablename,$str_ids){
			if(!$str_ids)
				return;
			if(!$tablename)
				$tablename = 'fs_products';
				global $db;
				$result = "";
			$query = " SELECT *
							FROM ".$tablename."
							WHERE record_id IN (".$str_ids.")
							AND published = 1 AND is_trash = 0
							ORDER BY POSITION(','+record_id+',' IN '".$str_ids."')
							";
				
				

				$sql = $db->query($query);
				return $list = $db->getObjectList();
		}
		
		function check_compare($list_product_id){
			global $db;
			if(!$list_product_id)
				return;
			$query = " SELECT DISTINCT tablename
					 FROM fs_products AS a 
					 WHERE 
						a.id IN ($list_product_id) ";
			$db->query($query);
			$result = $db->getObjectList();
			if(!count($result) || count($result) > 1)
				return false; 
			return $result[0]->tablename;
		}
		
		// get from fs_product
		function get_tablename(){
			global $db;
			$list_product_id = FSInput::get('list');
			if(!$list_product_id)
				return;
			$list_product_id = str_replace('_', ',', $list_product_id);
			$query = " SELECT DISTINCT tablename
					 FROM fs_products AS a 
					 WHERE 
						a.id IN ($list_product_id) ";
			$db->query($query);
			$result = $db->getResult();
			return $result;
		}
		
		/*
		 * get manufactories by list product id
		 */
		function get_manufactories($str_ids)
		{
			// get rootid
			if(!$str_ids)
				return ;
			
			global $db;
			// query get alias
			$query = " SELECT name, id
						FROM fs_manufactories 
						WHERE id IN ($str_ids) ";
			$sql = $db->query($query);
			$rs = $db->getObjectList();
			$manu = array();	
			for($i = 0; $i < count($rs); $i ++){
				$manu[$rs[$i] -> id ] = $rs[$i] -> name; 
			}
			return $manu;
		}
		/*
		 * get alias of parent_root
		 */
		function get_alias_parent_root($rootid)
		{
			// get rootid
			if(!$rootid)
				return 'products';
			
			global $db;
			// query get alias
			$query = " SELECT alias
						FROM fs_categories 
						WHERE id = $rootid ";
			$sql = $db->query($query);
			$root_alias = $db->getResult();	
			return $root_alias;
		}
		/*
		 * get alias of parent_root
		 */
		function get_ext_fields($tablename) {
			// get rootid
			if (! $tablename)
				return;
			
			global $db;
			// query get alias  
			// tam thơi xóa điều kiệns AND is_compare = 1
			$query = " SELECT *
			FROM fs_products_tables 
			WHERE table_name = '$tablename'
			ANd  is_filter <> 1  AND is_price <> 1
			ORDER BY ordering  
			";
			$db->query ( $query );
			$rs = $db->getObjectList ();
			return $rs;
		}
		function get_ext_group_fields($str_group_fields)
		{
				// get rootid
			if(!$str_group_fields)
				return ;
			
			global $db;
				// query get alias
			$query = " SELECT *
			FROM fs_products_fields_groups 
			WHERE id IN ($str_group_fields)
			ORDER BY ordering ASC ";
			$db->query($query);
			$rs = $db->getObjectListByKey('id');	
			return $rs;
		}
		
		function getCategory(){
			$cid = FSInput::get('cid',0,'int');
			$query = " SELECT alias,id, name, image, tablename, icon,list_parents,root_id
					FROM fs_products_categories 
					WHERE  id = $cid
					 ";
			
			global $db;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		/*
		 * Lấy dữ liệu từ các bảng mở rộng
		 */
		function get_data_foreign($table_name,$value,$type = 'foreign_one'){

			if(!$value)
				return;
			$where = '';
			if($type == 'foreign_one'){
				$where  = ' id = '.intval($value).' ';
				return $this -> get_result($where,$table_name,'name');
			}else{
				$where  = ' id IN (0'.$value.'0) ';
				$rs =  $this -> get_records($where,$table_name,'name' );
				$html = '<ul class="foreign_multi">';
				for($i = 0; $i < count($rs); $i ++){
					$html .= '<li>'.$rs[$i]->name.'</li>';		
				}
				$html .='</ul>';
				return $html;
			}
			
		}

		function get_data_extends() {
			return $this -> get_records('published = 1', 'fs_extends_items');	
		}
		
		function get_compare_product($table_name) {
			if (isset ( $_SESSION [$table_name] )) {
				$compare = $_SESSION [$table_name];
				global $db;
				$result = "";
				for($i  = 0;$i < 3; $i++ ){
					@$one =$compare[$i];
					if (! empty ( $one )) {
						$query = " SELECT name,id,image
									FROM fs_products
									WHERE id=$one
									AND published = 1
									";
						$sql = $db->query($query);
						$result [] = reset ($db->getObjectList());
					} else {
						$result [] = "";
					}
				}
				return $result;
			} else {
				return "";
			}
		}
		function set_query_body($table_name)
		{	
			if(!$table_name)
				return; 
			$where='';
			$query = " FROM ".$table_name." 
						  WHERE published = 1
						  	". $where.
						    " ORDER BY  id DESC
						 ";
			return $query;
		}
		function get_list($query_body, $tablename) {
			if (! $query_body)
				return;
			$this->page = FSInput::get('page');	
			$query_select = 'SELECT * ';
			$query = $query_select;
			$query .= $query_body;
			global $db;
			$db->query_limit ( $query, $this->limit, $this->page );
			$result = $db->getObjectList ();
			return $result;
		}
		function get_ajax_list($query_body)
		{
			//sanitize post value
			@$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			
			//validate page number is really numaric
//			if(!is_numeric($page_number)){die('Invalid page number!');}
			
			//get current starting point of records
			$position = ($page_number * $this->limit);
			$positio_end =$position+$this->limit;
			if(!$query_body)
				return;
				
			global $db;
			$query = " SELECT *";
			$query .= $query_body;
			$query .= "LIMIT $position, $positio_end";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function getTotal($query_body)
		{
			if(!$query_body)
				return ;
			global $db;
			$query = "SELECT count(*)";
			$query .= $query_body;
			$sql = $db->query($query);
			$total = $db->getResult();
			return $total;
		}
		
//		function getPagination($total)
//		{
//			FSFactory::include_class('Ajaxpagination');
//			$ajax_pagination = new AjaxPagination($this->limit,$total);
//			return $ajax_pagination;
//		}
		function getPagination($total) {
			FSFactory::include_class ( 'AjaxPagination' );
			$pagination = new AjaxPagination ( $this->limit, $total, $this->page );
			return $pagination;
		}
	
		function get_types(){
			return $list = $this -> get_records('published = 1','fs_products_types','id,name,image,alias','ordering ASC');
		}	
	}
	
?>