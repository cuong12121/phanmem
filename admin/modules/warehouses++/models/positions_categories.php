<?php 
class WarehousesModelsPositions_categories extends ModelsCategories
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 20;
		$this -> view = 'positions_categories';
		$this -> table_items = FSTable_ad::_('fs_warehouses_positions');
		$this -> table_name = FSTable_ad::_('fs_warehouses_positions_categories');
		$this -> arr_img_paths = array(array('resized',420,300,'cut_image'),array('compress',1,1,'compress'));
		$this -> img_folder = 'images/positions';
			// $this -> check_alias = 0;
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
		if(isset($_SESSION[$this -> prefix.'filter0'])){
			$filter = $_SESSION[$this -> prefix.'filter0'];
			if($filter){
				$where .= ' AND a.warehouses_id =  "'.$filter.'" ';
			}
		}
		if(!$ordering)
			$ordering .= " ORDER BY created_time DESC , id DESC ";


		if(isset($_SESSION[$this -> prefix.'keysearch'] ))
		{
			if($_SESSION[$this -> prefix.'keysearch'] )
			{
				$keysearch = $_SESSION[$this -> prefix.'keysearch'];
				$where .= " AND ( a.name LIKE '%".$keysearch."%'  )";
			}
		}

		$query = ' SELECT a.*
		FROM 
		'.$this -> table_name.' AS a
		WHERE 1=1'.
		$where.
		$ordering. " ";

		return $query;
	}

	/*
		 * select in category
		 */
	function get_categories_tree_warehouses($warehouses_id) {
		global $db;
		$where = '';
		$sql = " SELECT id, name, parent_id AS parent_id  ,level
		FROM " . $this->table_name . "
		WHERE 1=1 AND warehouses_id = ".$warehouses_id . $where;
		$db->query ( $sql );
		$categories = $db->getObjectList ();
		
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $categories );
		return $list;
	}


			/*
		 * select in category
		 */
			function get_warehouses_tree() {
				global $db;
				$where = '';
				if (isset ( $_SESSION [$this->prefix . 'category_keysearch'] )) {
					if ($_SESSION [$this->prefix . 'category_keysearch']) {
						$keysearch = $_SESSION [$this->prefix . 'category_keysearch'];
						$where .= " AND ( name LIKE '%" . $keysearch . "%' OR alias LIKE '%" . $keysearch . "%' OR id = '" . $keysearch . "')";
					}
				}
				$sql = " SELECT id, name
				FROM fs_warehouses
				WHERE 1=1 " . $where;
				$db->query ( $sql );
				$categories = $db->getObjectList ();

		// $tree = FSFactory::getClass ( 'tree', 'tree/' );
		// $list = $tree->indentRows2 ( $categories );
				return $categories;
			}

			/*
		 * Show list category of product follow page
		 */
			function get_categories_tree()
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

			function save($row = array(),$use_mysql_real_escape_string = 0){
				$warehouses_id = FSInput::get('warehouses_id');
				$id= FSInput::get('id',0,'int');
				$warehouses = $this-> get_record('id = '.$warehouses_id,'fs_warehouses','*');
				if(empty($warehouses)) {
					Errors::_(FSText::_('Kho không tồn tại!'));
					return false;
				} else {
					$row['warehouses_name'] = $warehouses-> name;
				}

						// parent
				$parent_id = FSInput::get('parent_id');
				if($id && ($id == $parent_id)){
					Errors::_('Parent can not itseft');
					return false;
				}

				if(@$parent_id)
				{
					$parent =  $this->get_record_by_id($parent_id,$this -> table_name);
					$row['list_parents_name'] = $parent-> list_parents_name.' > '.FSInput::get('name');
					$row['list_parents_code'] = $parent-> list_parents_code.'-'.FSInput::get('code');

				} else {
					$row['list_parents_name'] = FSInput::get('name');
					$row['list_parents_code'] = FSInput::get('code');
				}

				$id = parent::save($row);

				$this-> update_children($id);

				$this-> save_position($id);

				return $id;
			}

			function save_position($id){

				$cat = $this->get_record_by_id($id,$this -> table_name);
				for ($i=0; $i <110; $i++) { 
					$name = FSInput::get('name_position_'.$i);
					$code = FSInput::get('code_position_'.$i);
					$barcode = FSInput::get('barcode_position_'.$i);
					$limit = FSInput::get('limit_position_'.$i);

					$row2['name'] = $name;
					$row2['code'] = $code;
					$row2['barcode'] = $barcode;
					$row2['limit'] = $limit;

					$row2['category_id'] = $id;
					$row2['category_name'] = $cat-> name;
					$row2['list_parents_code'] = $cat-> list_parents_code;

					$row2['list_code'] = $cat-> list_parents_code.'-'.$code;

					$row2['list_parents_name'] = $cat-> list_parents_name;
					$row2['category_alias'] = $cat-> alias;
					$row2['list_parents'] = $cat-> list_parents;

					$warehouses_id = FSInput::get('warehouses_id');
					$row2['warehouses_id'] = $warehouses_id;

					$warehouses = $this-> get_record('id = '.$warehouses_id,'fs_warehouses','*');
					if(empty($warehouses)) {
						Errors::_(FSText::_('Kho không tồn tại!'));
						return false;
					} else {
						$row2['warehouses_name'] = $warehouses-> name;
					}

					if($name) {
						$id_detail = $this -> _add($row2,'fs_warehouses_positions',1);
					}	
				}


				$sumc = FSInput::get('sumc',0,'int');

				if($sumc) {
					for ($j=0; $j <$sumc; $j++) { 

						$name = FSInput::get('cname_position_'.$j);
						$code = FSInput::get('ccode_position_'.$j);
						$barcode = FSInput::get('cbarcode_position_'.$j);
						$limit = FSInput::get('climit_position_'.$j);

						$row2 = array();

						$warehouses_id = FSInput::get('warehouses_id');
						$row2['warehouses_id'] = $warehouses_id;

						
						$row2['name'] = $name;
						$row2['code'] = $code;
						$row2['barcode'] = $barcode;
						$row2['limit'] = $limit;

						$row2['category_id'] = $id;
						$row2['category_name'] = $cat-> name;
						$row2['list_parents_code'] = $cat-> list_parents_code;

						$row2['list_code'] = $cat-> list_parents_code.'-'.$code;

						$row2['list_parents_name'] = $cat-> list_parents_name;
						$row2['category_alias'] = $cat-> alias;
						$row2['list_parents'] = $cat-> list_parents;

						$cid = FSInput::get('cid_'.$j,0,'int');


						if($name) {
							$this -> _update($row2,'fs_warehouses_positions','id ='.$cid,1);	
						}

					}

				}
			}

			function update_children($id){
				$parent =  $this->get_record_by_id($id,$this -> table_name);
				$children = $this-> get_records('parent_id = '	.$id,$this -> table_name, '*');
				// print_r($children);die;
				if(empty($children)) return;
				foreach($children as $item){
					$row3 = array();
					$row3['list_parents_name'] = $parent-> list_parents_name.' > '.$item-> name;
					$row3['list_parents_code'] = $parent-> list_parents_code.'-'.$item-> code;
					// echo $row3['list_parents_name'];die;
					if($this -> _update($row3,$this -> table_name,' id = '.$item -> id.' ')){
						$row2 = array();
						$row2['list_parents_name'] = $row2['list_parents_name'];
						$row2['list_parents_code'] = $row2['list_parents_code'];

						$this -> _update($row2,$this -> table_items,' category_id = '.$item -> id.' ');
					}
					$this-> update_children($item -> id);
				}
			}


			function cdelete(){
				$id = FSInput::get ( 'id', 0, 'int' );
				$rs = $this-> _remove('id='.$id , $this -> table_items);
			}


//		
//		/*
//		 * select in category
//		 */
//		function get_categories_tree()
//		{
//			global $db;
//			$query = $this->setQuery();
//			$sql = $db->query($query);
//			$result = $db->getObjectList();
//			$tree  = FSFactory::getClass('tree','tree/');
//			$list = $tree -> indentRows2($result);
//			$limit = $this->limit;
//			$page  = $this->page?$this->page:1;
//			
//			$start = $limit*($page-1);
//			$end = $start + $limit;
//			
//			$list_new = array();
//			$i = 0;
//			foreach ($list as $row){
//				if($i >= $start && $i < $end){
//					$list_new[] = $row;
//				}
//				$i ++;
//				if($i > $end)
//					break;
//			}
//			return $list_new;
//		}
//		
//		/*
//		 * select in category by estore_id
//		 */
//		/*
//		 * value: == 1 :hot
//		 * value  == 0 :unhot
//		 * published record
//		 */
//		function home($value)
//		{
//			$ids = FSInput::get('id',array(),'array');
//			
//			if(count($ids))
//			{
//				global $db;
//				$str_ids = implode(',',$ids);
//				$sql = " UPDATE ".$this -> table_name."
//							SET show_in_homepage = $value
//						WHERE id IN ( $str_ids ) " ;
//				$db->query($sql);
//				$rows = $db->affected_rows();
//				return $rows;
//			}
//			return 0;
//		}
//		
//		
//		/*
//		 * Save
//		 */
//		function save($row = array(),$use_mysql_real_escape_string = 0){
//			$name = FSInput::get('name');
//			if(!$name){
//				Errors::_(FSText::_('Name is not empty'));
//				return false;
//			}
//			$id = FSInput::get('id',0,'int');
//			$icon = $_FILES["icon"]["name"];
//			if($icon){
//				
//				// remove old if exists record and img
//				
//				$path_original =  PATH_IMG_NEWS.'categories'.DS.'icons'.DS.'original'.DS;
//				$path_resize =  PATH_IMG_NEWS.'categories'.DS.'icons'.DS.'resized'.DS;
//				
//				if($id){
//					$img_paths = array();
//					$img_paths[] = $path_original;
//					$img_paths[] = $path_resize;
//					$this -> remove_image($id,$img_paths);
//				}
//				$fsFile = FSFactory::getClass('FsFiles');
//				// upload
//				$icon = $fsFile -> uploadImage("icon", $path_original ,2000000, '_'.time());
//				if(!$icon){
//					Errors::_(FSText::_('Can not upload image'));
//					return false;
//				}
//					
//				// rezise to standart : 34x27
//				$width = 34;
//				$height = 27;
//				if(!$fsFile ->resized_not_crop($path_original.$icon, $path_resize.$icon,$width, $height))
//				{
//					Errors::_(FSText::_('Can not resize image'));
//					return false;
//				}
//				$row['icon'] = 	$icon;
//			}
//				
//			$alias= FSInput::get('alias');
//			$fsstring = FSFactory::getClass('FSString','','../');
//			if(!$alias){
//				$row['alias'] = $fsstring -> stringStandart($name);
//			} else {
//				$row['alias'] = $fsstring -> stringStandart($alias);
//			}
//			
//			// change in table fs_news
//			if($id)
//				$this -> change_table_child($row['alias'],'category_alias',' WHERE category_id = '.$id,'fs_news');
//			return parent::save($row);
//		}
//		
//		
//		function remove(){
//			if(!$this -> check_remove()){
//				Errors::_(FSText::_('Can not remove category when it has child category or article'));
//				return false;
//			}
//			return parent::remove();
//		}
//		
//		function check_remove(){
//			$cids = FSInput::get('id',array(),'array');
//			foreach ($cids as $cid)
//			{
//				if( $cid != 1)
//				{
//					$cids[] = $cid ;
//				}
//			}
//			
//			$num_record = 0;
//			if(count($cids))
//			{
//				$str_cids = implode(',',$cids);
//				global $db;
//				
//				$sql = " SELECT count(*) FROM  ".$this -> table_name." 
//						WHERE id not IN ( $str_cids ) 
//						AND parent_id IN ( $str_cids ) " ;
//				$db->query($sql);
//				$result = $db->getResult();
//				if($result)
//					return false;
//					
//				$sql = " SELECT count(*) FROM  ".$this -> table_news." 
//						WHERE category_id IN ( $str_cids ) 
//						 " ;
//				$db->query($sql);
//				$result = $db->getResult();
//				if($result)
//					return false;
//			}
//			return true;
//		}
		}

	?>