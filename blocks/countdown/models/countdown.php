<?php 
	class CountdownBModelsCountdown extends FSModels
	{
		function __construct()
		{
		}
		function setQuery($ordering,$limit,$type){
			$where = '';
			$order = '';
			global $tmpl;
			switch ($type){
			case 'new':
				$where .= 'AND is_new = 1';	
				break;	 
			case 'selling':
				$where .= 'AND is_sell = 1';	
				$order .= 'sale_count DESC,';
			break;
			case 'relate':
				$products_related = $tmpl -> get_variables('products_related');
				if($products_related){
				$product_id = substr($products_related, 1, -1);  // retourne "abcde"
					if($product_id)
	 					$where .= ' AND id IN ('.$product_id.')';
	 				else 
	 					$where .= ' AND 1 = 0';
				}else{
//				  	 $tag = $tmpl -> get_variables('tags_news');
//				  	if(!$tag)
//				  		break;
//					$arr_tags = explode ( ',', $tag );
//					$total_tags = count ( $arr_tags );
//					if ($total_tags) {
//						$where .= ' AND (';
//						$j = 0;
//						for($i = 0; $i < $total_tags; $i ++) {
//							$item = trim ( $arr_tags [$i] );
//							if ($item) {
//								if ($j > 0)
//									$where .= ' OR ';
//									$where .= " tags like '%" . $item . "%'";
//								$j ++;
//							}
//						}
//						 $where .= ' )';
//					}
				}
				break;
			case 'hot':
				$where .= 'AND is_hot= 1';	
			break;		
			case 'old':
				$where .= 'AND is_old = 1';
			break;
                case 'promotion':
	                $where .= 'AND is_hotdeal = 1  AND date_start < NOW() AND date_end > NOW() AND is_hotdeal_show_home =1 ';
                break;
			case 'in_cat':
				$ccode = FSInput::get('ccode');
				$id = FSInput::get('id');
				if($ccode)
					$where .= 'AND id <>'.$id.' AND category_alias_wrapper LIKE "%,'.$ccode.',%" ';
				else 
					return;
				break;
			}
			$order .= ' ordering DESC,created_time DESC';
			
			 $query = " SELECT id,name,is_accessories,alias,image,category_alias,price,price_old,quantity,hits,sale_count,discount,date_start,date_end,warranty,summary,types,is_hotdeal,accessories  
						 FROM fs_products
						 WHERE  published = 1 and category_published = 1 ".$where."
						 ORDER BY  ".$order."
						 LIMIT $limit  
						 ";
			return $query;			
		}
		function get_list($ordering,$limit,$type){
	
			global $db;
				$query = $this->setQuery($ordering,$limit,$type);
			if(!$query)
				return;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function get_types(){
			global $db;
				$query = "SELECT id,name,image
					 FROM fs_products_types
					 WHERE  published = 1
				";
			if(!$query)
				return;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
	}		
?>