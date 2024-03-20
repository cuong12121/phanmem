<?php 
	class PromotionModelsPromotion extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'promotion';
			
			$this -> arr_img_paths = array(array('resized',258,152,'resized_not_crop'),array('small',80,80,'resized_not_crop'));
			$this -> table_name = 'fs_promotion';
			
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/promotion/'.$cyear.'/'.$cmonth.'/'.$cday;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			
			parent::__construct();
		}
		/*
		 * select in category of home
		 */
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT a.*
					   FROM fs_products_categories AS a
					   ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
		function save($row = array()) {
			$id = FSInput::get ( 'id', 0, 'int' );
			
			//time promotion
			$date_start = FSInput::get('date_start');
			$published_hour_start = FSInput::get('published_hour_start',date('H:i'));
			$date_end = FSInput::get('date_end');
			$published_hour_end = FSInput::get('published_hour_end',date('H:i'));
			if($date_start){
				$row['date_start'] = date('Y-m-d H:i:s',strtotime($published_hour_start. $date_start));
			}
			if($date_end){
				$row['date_end'] = date('Y-m-d H:i:s',strtotime($published_hour_end. $date_end));
			}
			if( date('Y-m-d H:i:s') > $row['date_end'] || date('Y-m-d H:i:s') > $row['date_start']){
				Errors::_ ( 'Thời gian khuyến mại đã quá hạn','alert' );
			}
			if($row['date_start']  > $row['date_end']){
				Errors::_ ( 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc','alert' );			
			}
			
			$id = parent::save ( $row );
			if (! $id) {
				Errors::setError ( 'Not save' );
				return false;
			}
			if($id){
				$this -> save_promotion_products($id);
			}
			return $id;
		}
		function save_promotion_products($product_id){
				if(!$product_id)
					return;
				global $db;
				$query = ' SELECT id,product_incenty_id,product_id 
							FROM fs_promotion_products
							WHERE product_id =  '.$product_id ;
				$db->query($query);
				$list = $db->getObjectList();
				if(count($list)){
					foreach($list as $item){
						$product_incenty_id = $item -> product_incenty_id;
						$price_new = FSInput::get('price_new_'.$product_incenty_id);
						$price_new_begin = FSInput::get('price_new_'.$product_incenty_id."_begin");
						
						if($price_new != $price_new_begin){
							$sql = ' UPDATE  fs_promotion_products SET ';
				            $sql .=  ' `price_new` =  "'.$price_new.'"';
				            $sql .=  ' WHERE product_id =    '.$product_id.' ';
				            $sql .=  ' AND product_incenty_id = '.$product_incenty_id.' ';
				            
				            // $db->query($sql);
				            $db->affected_rows($sql);
						}
					}
				}
			}
		function get_promotion_products($product_id){
				
			$query   = " SELECT b.name,b.id, a.price_old,a.price_new,a.product_incenty_id 
						FROM fs_promotion_products AS a
						LEFT JOIN fs_products AS b ON a.product_incenty_id = b.id
						WHERE a.product_id = $product_id";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;	
		}
		function remove_promotion_product(){
			
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
			if(!$rs)	
				return;
	
			$arr = explode( ',',$rs);
			if(!count($arr))
				return;
			$str = '';
			$i  = 0;
			foreach($arr as $item){
				if($item != $promotion_product_id){
					if($i > 0)
						$str .= ',';
					$str .= $item;
					$i ++;
				}
			}	
			$row['promotion_products'] = $str;
			print_r($row);
				
			// remove from fs_products_incentives
			$this -> remove_from_promotion_products($id ,$promotion_product_id);			
			return $this -> _update($row,'fs_promotion','id = '.$id .'');
		}
		function remove_from_promotion_products($id ,$promotion_product_id){
			$sql = " DELETE FROM fs_promotion_products
						WHERE product_id = $id
							AND product_incenty_id = $promotion_product_id " ;
			global $db;
			// $db->query($sql);
			$rows = $db->affected_rows($sql);
		}
	}
?>