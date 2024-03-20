<?php 
class ProductsModelsManufactories extends FSModels
{
	var $limit;
	var $page;
	function __construct()
	{
		$limit = 100;
		$page = FSInput::get('page');
		$this->limit = $limit;
		$this -> table_items = 'fs_products';
		$this -> table_name = 'fs_manufactories';
			//synchronize
		$this -> check_alias = 1;
		$this -> table_product = 'fs_products';
		$this-> arr_img_paths = array (array ('resized', 250, 110, 'cut_image' ),array ('large', 250, 110, 'resize_image' ));
		$this -> arr_img_paths_icon = array(array('resized',100,100,'cut_image'));
		$this -> img_folder = 'images/products/manufactories';

		$this->field_img = 'image';
		parent::__construct();
	}
	
	function setQuery()
	{
			// ordering
		$ordering = '';
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
			$ordering .= " ORDER BY ordering ASC, created_time DESC , id DESC ";
		
		if(isset($_SESSION[$this -> prefix.'keysearch'] ))
		{
			if($_SESSION[$this -> prefix.'keysearch'] )
			{
				$keysearch = $_SESSION[$this -> prefix.'keysearch'];
				$where .= " AND name LIKE '%".$keysearch."%' ";
			}
		}
		$query = " 	   SELECT * 
		
		FROM ".$this -> table_name." 
		WHERE 1=1 ".
		$where.
		$ordering. " ";
		return $query;
	}
	

	function get_manufactories_tree()
	{
		global $db;
		$query = $this->setQuery();
		$sql = $db->query($query);
		$result = $db->getObjectList();
		$tree  = FSFactory::getClass('tree','tree/');
		$list = $tree -> indentRows2($result);
		$limit = $this->limit;
		$page  = $this->page?$this->page:1;
		
		$start = $limit*($page-1);
		$end = $start + $limit;
		
		$list_new = array();
		$i = 0;
		foreach ($list as $row){
			if($i >= $start && $i < $end){
				$list_new[] = $row;
			}
			$i ++;
			if($i > $end)
				break;
		}
		return $list_new;
	}
		/*
		 * Select all list category of product
		 */
		function get_categories_tree_all()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			
			return $list;
		}
		
		/*
		 * get Tablename product
		 */
		function get_tablenames()
		{
			global $db;
			$query = " 	   SELECT DISTINCT(a.table_name) as table_name
			FROM fs_products_tables AS a 
			";
			$db->query($query);
			$result = $db->getObjectList();
			$result = array_merge( array(0=>(object) array('table_name'=>'fs_products')),$result);
			
			return $result;
		}
		
		
		
		
		/*
		 * Save into tble fs_manufactories
		 */

		function save($row = array(), $use_mysql_real_escape_string = 1){
			$name = FSInput::get ('name');
			$id = FSInput::get ('id');
			$this->save_new_session();
			if(!$id){
				$check_name = $this->get_result('name="'.$name.'"');
				if($check_name){
					setRedirect('index.php?module=products&view=manufactories&task=add',FSText :: _('Tên hãng đã tồn tại !'),'error');
					return false;
				}
				
			}else{
				$check_name = $this->get_result('name="'.$name.'" AND id != '.$id);
				if($check_name){
					setRedirect('index.php?module=products&view=manufactories&task=edit&id='.$id,FSText :: _('Tên hãng đã tồn tại !'),'error');
					return false;
				}
			}





			$alias= FSInput::get('alias');
			$id= FSInput::get('id',0,'int');

			$tablename = FSInput::get('tablenames',array(),'array');
			$str_tables = '';
			$fsstring = FSFactory::getClass('FSString','','../');
			
			if(!$alias){
				$row['alias'] = $fsstring -> stringStandart($name);
			} else {
				$row['alias'] = $fsstring -> stringStandart($alias);
			}
			for($i = 0 ; $i < count($tablename); $i ++ ){
				if($i)
					$str_tables .= ',';
				$item    = $tablename[$i];
				$str_tables .=  $item;
			}
			if($str_tables)
				$str_tables = ','.$str_tables.',';
			$row['tablenames'] = $str_tables;

						// parent
			$parent_id = FSInput::get('parent_id');
			if($id && ($id == $parent_id)){
				Errors::_('Parent can not itseft');
				return false;
			}
			if(@$parent_id)
			{
				$parent =  $this->get_record_by_id($parent_id,$this -> table_name);
				$parent_level = $parent -> level ?$parent -> level : 0; 
				$level = $parent_level + 1;
			} else {
				$level = 0;
			}
			$row['level'] = $level;
			
			$record_id =  parent::save($row);
			if($record_id){

				$record = $this -> get_record('id = '.$record_id.'',$this -> table_name);
				$this -> update_parent($record_id,$row['alias']);
				// update bảng sp
				$this -> update_table_products($record_id,$record);
				// update bảng mở rộng
				$this -> update_table_products_extend($record_id,$record);
			}
			return $record_id;
		}


					/*
		 * Update table table category And table table items
		 */
					function update_parent($cid,$alias){
					//	echo $cid;
						$record =  $this->get_record_by_id($cid,$this -> table_name);
					//	print_r($record);
					//	die();
						if($record -> parent_id){
							$parent =  $this->get_record_by_id($record -> parent_id,$this -> table_name);
							$list_parents = ','.$cid.$parent -> list_parents ;
							$alias_wrapper = ','.$alias.$parent -> alias_wrapper ;
							if(isset($parent->tablenames)){
								$row['tablenames'] =  $parent->tablenames;	
							}
						} else {
							$list_parents = ','.$cid.',';
							$alias_wrapper = ','.$alias.',' ;
						}
						$row['list_parents'] = $list_parents;
						$row['alias_wrapper'] = $alias_wrapper;

			// update table items
						$id = FSInput::get('id',0,'int');
						if($id){
							$row2['manufactory_id_wrapper'] = $list_parents;
							$row2['manufactory_alias'] = $record -> alias;
							$row2['manufactory_alias_wrapper'] =  $alias_wrapper;
							$row2['manufactory_name'] =  $record -> name;
						//	$row2['manufactory_published'] =  $record -> published;

							$this -> _update($row2,$this -> table_items,' manufactory = '.$cid.' ');
							//$this -> _update($row2,'fs_products_laptop',' manufactory = '.$cid.' ');
						//	$this -> _update($row2,'fs_products_dienthoai',' manufactory = '.$cid.' ');
							//$this -> _update($row2,'fs_products_tablet',' manufactory = '.$cid.' ');
						//	$this -> _update($row2,'fs_products_macbook',' manufactory = '.$cid.' ');

				// update table categories : records have parent = this
							$this -> update_manufactory_children($cid,0,$list_parents,'',$alias_wrapper,$record -> level);
						}
			// change this record
						$rs =  $this -> record_update($row,$cid);
			// update sitemap
//			$this -> update_sitemap($cid,$this -> table_name,$this -> module);
						return $rs;
					}


					function update_manufactory_children($parent_id,$root_id,$list_parents,$root_alias,$alias_wrapper,$level){
						if(!$parent_id)
							return;
						$query = ' SELECT * FROM '.$this -> table_name.' 
						WHERE parent_id = '	.$parent_id;
						global $db;
						$db->query($query);
						$result = $db->getObjectList();	
						if(!count($result))
							return;
						foreach($result as $item){
							$row3['list_parents'] = ",".$item -> id.$list_parents;
							$row3['alias_wrapper'] = ",".$item -> alias.$alias_wrapper;
							$row3['level'] =  ($level + 1) ;
							if($this -> _update($row3,$this -> table_name,' id = '.$item -> id.' ')){
					// update sitemap
//					$this -> update_sitemap($item -> id,$this -> table_name,$this -> module);

					// update table items owner this category
								$row2['category_id_wrapper'] = $row3['list_parents'];
								$row2['category_alias_wrapper'] =  $row3['alias_wrapper'];
//					$row2['category_name'] =  $row3['name'];
								$this -> _update($row2,$this -> table_items,' manfactory_id = '.$item -> id.' ');

					// đệ quy
//					$this -> update_categories_children($item -> id,$root_id,$row3['list_parents'],$root_alias,$row3['alias_wrapper'],$level);
							}
							$this -> update_manufactory_children($item -> id,$root_id,$row3['list_parents'],$root_alias,$row3['alias_wrapper'],$row3['level']);
						}
					}

		/*
		 * Update table  table fs_products
		 * Chú ý: toàn bộ các bảng con của sp phải đồng bộ lại hết
		 */
		function update_table_products($cid,$manufactory){
			$row['manufactory_alias'] = $manufactory->alias;
			$row['manufactory_name'] = $manufactory->name;
			
			$row['manufactory_alias_wrapper'] = $manufactory->alias_wrapper;
			$row['manufactory_id_wrapper'] = $manufactory->list_parents;
			return $this -> _update($row,'fs_products','  manufactory = '.$cid.' ');
		}
		/*
		 * Update manufactory tại các bảng mở rộng
		 */
		function update_table_products_extend($cid,$manufactory){
			$tables = $this -> get_records(' manufactory = '.$cid.' ','fs_products',' DISTINCT(tablename) ');
			if(!count($tables))
				return true;
			foreach($tables as $table){
				$table_name = $table -> tablename;
				if(!$table_name)
					continue;
				$row['manufactory_alias'] = $manufactory->alias;
				$row['manufactory_name'] = $manufactory->name;
				$row['manufactory_image'] = $manufactory->image;
				$row['manufactory_alias_wrapper'] = $manufactory->alias_wrapper;
				$row['manufactory_id_wrapper'] = $manufactory->list_parents;
				
				return $this -> _update($row,$table_name,' manufactory = '.$cid.' ');
			}
		}
		
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
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
		
		
	}
	
	?>