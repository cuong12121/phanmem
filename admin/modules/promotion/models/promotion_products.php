<?php 
	class PromotionModelsPromotion_products extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 12;
			$this -> view = 'products_incentives';
			$this -> table_name = 'fs_products';
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			$cat_id = FSInput::get('cid',0,'int');
			$where .= ' AND a.is_accessories = 1 ';
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
			$where .= ' AND is_accessories = 1 ';
			
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
			$promotion_product_id = FSInput::get('promotion_product_id',0,'int');
			if(!$id || !$promotion_product_id)	
				return;
			if($id == $promotion_product_id)
				return;	
			$sql = " SELECT promotion_products 
				FROM fs_promotion 
				WHERE id = $id
				AND (promotion_products = $promotion_product_id
					OR promotion_products like '%,".$promotion_product_id.",%'
					OR promotion_products like '".$promotion_product_id.",%'
					OR promotion_products like '%,".$promotion_product_id."'
					)
					";
			global $db ;
			// $db->query($sql);
			$rs =  $db->getResult($sql);
			return !$rs;
		}
		
		function add_promotion_products(){
			
			$id = FSInput::get('id',0,'int');
			
			$promotion_product_id = FSInput::get('promotion_product_id',0,'int');
			if(!$id || !$promotion_product_id)	
				return;
				
			$sql = " SELECT promotion_products
				FROM fs_promotion 
				WHERE id = $id
					";
			global $db ;
			// $db->query($sql);
			$rs =  $db->getResult($sql);
			
			$str = '';
			if($rs){
				$str = $rs . ','.$promotion_product_id;
			}else{
				$str = $promotion_product_id;
			}
			$row['promotion_products'] = $str;
			
			$this -> insert_into_promotion_products($id,$promotion_product_id);
			return $this -> _update($row,'fs_promotion','id = '.$id .'');
		}

		function get_product_name(){
			$promotion_product_id = FSInput::get('promotion_product_id',0,'int');
			if(!$promotion_product_id)	
				return;
			$sql = " SELECT name
				FROM fs_products 
				WHERE id = $promotion_product_id
					";
			global $db ;
			// $db->query($sql);
			$rs =  $db->getResult($sql);
			return $rs;
		}
		
		// insert new product_incentives into table fs_products_incentives 
		function insert_into_promotion_products($id,$promotion_product_id){
			$sql = " SELECT price,name
				FROM fs_products 
				WHERE id = $promotion_product_id
					";
			global $db ;
			// $db->query($sql);
			$product =  $db->getObject($sql);
			$row['product_id'] = $id;
			$row['product_incenty_id'] = $promotion_product_id;
			$row['product_incenty_name'] = $product -> name;
			$row['price_old'] = $product -> price;
			$row['price_new'] = $product -> price;
			
			return $this -> _add($row, 'fs_promotion_products');
		}
	}
	
?>