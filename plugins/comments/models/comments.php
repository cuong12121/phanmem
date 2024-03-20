<?php 
	class CommentsPModelsComments extends FSModels
	{
		function __construct()
		{
			$limit = 5;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
			$this->module  = FSInput::get('module');  
		}
		function set_query_body()
		{
			$id = FSInput::get('id',0,'int');
			if($this->module=='installment'){
		
				$record_id=$this->get_record('published=1','fs_installment');
				$id=$record_id->id;

			}
			if(!$id){
				global $tmpl;
				$id  = $tmpl -> get_variables('id');
			}
			
			$fs_table = FSFactory::getClass('fstable');
			$query = " FROM fs_".$this->module."_comments
						  WHERE  record_id = $id 
								AND published = 1 
						 ";
			return $query;
		}
		function get_parents($query_body) {
			if (! $query_body)
				return;
			$this->page = FSInput::get('page');	
			$query_select = 'SELECT name,created_time,id,email,comment,parent_id,level,record_id,is_admin,avatar ';
			$query = $query_select;
			$query .= $query_body.' AND parent_id = 0 ';
			$query .= ' ORDER BY  id DESC  ';
			global $db;
			$db->query_limit ( $query, $this->limit, $this->page );
			$result = $db->getObjectList ();
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
		function get_list($query_body) {
			if (! $query_body)
				return;
			$this->page = FSInput::get('page');	
			$query_select = 'SELECT name,created_time,id,email,comment,parent_id,level,record_id,is_admin,avatar ';
			$query = $query_select;
			$query .= $query_body.' AND parent_id > 0 ';
			$query .= ' ORDER BY  id ASC  ';
			global $db;
//			$db->query_limit ( $query, $this->limit, $this->page );
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
		function getPagination($total,$data) {
			FSFactory::include_class ( 'AjaxPagination' );
			$module = FSInput::get('module');
			$pagination = new AjaxPagination ( $this->limit, $total, $this->page, '/index.php?module=comments&view=comments&raw=1&id='.$data -> id.'&cmt_module='.$module.'&cmt_view=product' );
			return $pagination;
		}

		function get_comments_child($parent_id) {
			global $db;
			if (! $parent_id)
				return;
			$query = " SELECT name,created_time,id,email,comment,parent_id,level,record_id,is_admin,avatar
							FROM fs_".$this->module."_comments
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