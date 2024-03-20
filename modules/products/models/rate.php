 <?php
class ProductsModelsRate  extends FSModels {

	function __construct()
	{
		$limit = 20;
		parent::__construct ();
		// $page = FSInput::get('page');
		$this->limit = $limit;
		$page = FSInput::get('page');
		$this->page = $page;
		$this->module  = FSInput::get('module');  
	}
	
	function set_query_body()
	{
		$id = FSInput::get('id',0,'int');
		if(!$id){
			global $tmpl;
			$id  = $tmpl -> get_variables('id');
		}
			
		$fs_table = FSFactory::getClass('fstable');
		$query = " FROM fs_".$this->module."_rates
						  WHERE  record_id = $id 
								AND published = 1 
						 ";
		return $query;
	}
	function get_parents($query_body) {
		if (! $query_body)
			return;
		$this->page = FSInput::get('page');	
		$query_select = 'SELECT name,created_time,id,email,comment,rate,parent_id,level,record_id,is_admin,avatar ';
		$query = $query_select;
		$query .= $query_body.' AND parent_id = 0 ';
		$query .= ' ORDER BY  id DESC  ';
		global $db;
		$db->query_limit ( $query, $this->limit, $this->page );
		$result = $db->getObjectList ();
		return $result;
	}
		function getCategoryById($id) {
		if (! $id)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT *
						FROM " . $fs_table->getTable ( 'fs_products_categories' ) . " 
						WHERE id = $id ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	 function get_filter_menu($manu_id,$table_name){
		 	if(!$manu_id || !$table_name)
		 		return;
		 	return $this -> get_record(' tablename = "'.$table_name.'" AND field_name = "manufactory" AND filter_value = "'.$manu_id.'" ','fs_products_filters','*');	
		 }

	function get_list($query_body) {
		if (! $query_body)
			return;
		$this->page = FSInput::get('page');	
		$query_select = 'SELECT name,created_time,id,email,comment,rate,parent_id,level,record_id,is_admin,avatar ';
		$query = $query_select;
		$query .= $query_body.' AND parent_id > 0 ';
		$query .= ' ORDER BY  id ASC  ';
		global $db;
//		$db->query_limit ( $query, $this->limit, $this->page );
		$result = $db->getObjectList ($query);
		return $result;
	}
	function getTotal($query_body)
		{
			if(!$query_body)
				return ;
			global $db;
			$query = "SELECT count(*)";
			$query .= $query_body.' AND parent_id = 0 ';
			$sql = $db->query($query);
			$total = $db->getResult();
			return $total;
		}
	function getPagination($total) {
		FSFactory::include_class ( 'Pagination' );
		$pagination = new Pagination ( $this->limit, $total, $this->page );
		return $pagination;
	}	
		function get_countr($id){
		$idp = FSInput::get('id',0,'int');
		if(!$id)
			return;
		$where="";
		$where .= 'published=1 AND record_id= '.$idp.' AND rate='.$id ;
		$query = " SELECT count(*)
		FROM fs_".$this->module."_rates
		WHERE ".$where ;
		
		global $db;
		$result = $db->getResult($query);
		return $result;
	}
	function get_countrate($id){

		if(!$id)
			return;

		$where="";
		$where .= 'published=1 AND parent_id= '.$id ;
		$query = " SELECT count(*)
		FROM fs_".$this->module."_rates
		WHERE ".$where ;
		
		global $db;
		$result = $db->getResult($query);
		return $result;
	}
	

	function get_rates_child($parent_id) {
		global $db;
		if (! $parent_id)
			return;
		$query = " SELECT name,created_time,id,email,comment,rate,parent_id,level,record_id,is_admin,avatar
							FROM fs_".$this->module."_rates
							WHERE parent_id = $parent_id 
								AND published = 1 
							ORDER BY  created_time  DESC
							";
		$db->query ( $query );
		$result = $db->getObjectList ();
			
		$tree  = FSFactory::getClass('tree','tree/');
		$list = $tree -> indentRows2($result);
			return $list;
		}


}
	
	?>