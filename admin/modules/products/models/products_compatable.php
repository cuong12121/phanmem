<?php 
	class ProductsModelsProducts_compatable extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 12;
			$this -> view = 'products_compatable';
			$this -> table_name = 'fs_products';
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			$cat_id = FSInput::get('cid',0,'int');
			$is_accessory = FSInput::get('is_accessory',0,'int');
			if($is_accessory){
				$where .= ' AND a.is_accessories = 0 ';
			} else {
				$where .= ' AND a.is_accessories = 1 ';
			}
			$id = FSInput::get('id',0,'int');
			if(!$id)	
				return;
			if($cat_id){
				$where .= ' AND (a.category_id =  "'.$cat_id.'"
								OR a.category_id_wrapper LIKE "%,'.$cat_id.',%"	) ';
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			$query = " SELECT a.*,c.name as category_name
						  FROM 
						  	fs_products AS a
							LEFT JOIN fs_products_categories AS c ON a.category_id  = c.id
						  	WHERE a.id <> $id
						  	".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		/*
		 * select in category
		 */
		function get_categories_tree()
		{
			$where = '';
			$is_accessory = FSInput::get('is_accessory',0,'int');
			if($is_accessory){
				$where .= ' AND is_accessories = 0 ';
			} else {
				$where .= ' AND is_accessories = 1 ';
			}
			
			global $db ;
			$sql = " SELECT id, name, parent_id AS parentid 
				FROM fs_products_categories 
				WHERE 1 = 1
				".$where;
			// $db->query($sql);
			$categories =  $db->getObjectList($sql);
			
			$tree  = FSFactory::getClass('tree','tree/');
			$rs = $tree -> indentRows($categories,1); 
			return $rs;
		}
		function check_add(){
			$id = FSInput::get('id',0,'int');
			$product_compatable_id = FSInput::get('product_compatable_id',0,'int');
			if(!$id || !$product_compatable_id)	
				return;
			if($id == $product_compatable_id)
				return;	
			$sql = " SELECT products_compatable 
				FROM fs_products 
				WHERE id = $id
				AND (products_compatable = $product_compatable_id
					OR products_compatable like '%,".$product_compatable_id.",%'
					OR products_compatable like '".$product_compatable_id.",%'
					OR products_compatable like '%,".$product_compatable_id."'
					)
					";
			global $db ;
			// $db->query($sql);
			$rs =  $db->getResult($sql);
			return !$rs;
		}
		
		function add_product_compatable(){
			$id = FSInput::get('id',0,'int');
			$product_compatable_id = FSInput::get('product_compatable_id',0,'int');
		
			if(!$id || !$product_compatable_id)	
				return;
				
			$sql = " SELECT products_compatable 
				FROM fs_products 
				WHERE id = $id
					";
			global $db ;
			// $db->query($sql);
			$rs =  $db->getResult($sql);
			
			$str = '';
			if($rs){
				$str = $rs . ','.$product_compatable_id;
			}else{
				$str = $product_compatable_id;
			}
			$row['products_compatable'] = $str;
			return $this -> _update($row,'fs_products','id = '.$id .'');
		}

		function get_product_name(){
			$product_compatable_id = FSInput::get('product_compatable_id',0,'int');
			if(!$product_compatable_id)	
				return;
			$sql = " SELECT name
				FROM fs_products 
				WHERE id = $product_compatable_id
					";
			global $db ;
			// $db->query($sql);
			$rs =  $db->getResult($sql);
			return $rs;
		}
	}
	
?>