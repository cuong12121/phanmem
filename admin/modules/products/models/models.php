<?php 
	class ProductsModelsModels extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'models';
			
			$this -> table_category_name = 'fs_manufactories';
			$this -> table_name = 'fs_products_models';
			$this -> table_product = 'fs_products';
			parent::__construct();
				$this -> check_alias = 1;
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
			// manufactory_id
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.manufactory_id =  "'.$filter.'" ';
				}
			}
			$query = " SELECT a.*, b.name as category_name
						  FROM 
						  	".$this -> table_name." AS a
						  	LEFT JOIN ".$this -> table_category_name." AS b ON a.manufactory_id = b.id
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		function save(){
			$name = FSInput::get('name');
			if(!$name)
				return false;
			$id = FSInput::get('id',0,'int');	
			$alias= FSInput::get('alias');
			$fsstring = FSFactory::getClass('FSString','','../');
			if(!$alias){
				$row['alias'] = $fsstring -> stringStandart($name);
			} else {
				$row['alias'] = $fsstring -> stringStandart($alias);
			}
			$manufactory_id = FSInput::get('manufactory_id',0,'int');
			$manufactory =  $this->get_record_by_id($manufactory_id,'fs_manufactories');
			$row['manufactory_alias'] = $manufactory -> alias;
			
			if($this -> check_exist($row['alias'],$id)){
				Errors::_('Alias của bạn đã bị trùng tên');
				return false;
			}
			
			$record_id =  parent::save($row);
			if($record_id){
				$this -> update_table_products($record_id,$row['alias'],$name);
			}
			return $record_id;
		}
		
	/*
		 * Update table  table fs_products
		 */
		function update_table_products($cid,$alias,$name){
				$row['model_alias'] = $alias;
				$row['model_name'] = $name;
				return $this -> _update($row,'fs_products',' model = '.$cid.' ');
		}
		
		
//		function remove(){
//			if(!$this -> check_remove()){
//				Errors::_('Không thể xóa vì những category vẫn còn category con hoặc sản phẩm');
//				return false;
//			}
//			$img_paths = array();
//			$img_paths[] = PATH_IMG_PRODUCTS.'manufactories'.DS.'original'.DS;
//					$img_paths[] = PATH_IMG_PRODUCTS.'manufactories'.DS.'resized'.DS;
//			
//			return parent::remove('image',$img_paths);
//		}
		
		function check_remove(){
			$cids = FSInput::get('id',array(),'array');
			
			foreach ($cids as $cid)
			{
				if( $cid != 1)
				{
					$cids[] = $cid ;
				}
			}
			if(count($cids))
			{
				$str_cids = implode(',',$cids);
				global $db;
				
				$sql = " SELECT count(*) FROM  ".$this -> table_product." 
						WHERE manufactory IN ( $str_cids ) 
						 " ;
				// $db->query($sql);
				$result = $db->getResult($sql);
				if($result)
					return false;
			}
			return true;
		}
		/*
		 * select in category of home
		 */
		function get_menufactories()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_category_name." AS a
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
	}
?>