
<?php 
	class AqBModelsAq
	{
		function __construct()
		{
		}
	

		function setQuery($ordering,$limit,$type,$str_pcat){
			$where = '';
			$order = '';	
			if($str_pcat) {
				$where .= ' AND ( 1 = 2';
					$arrstr_pcat = explode(",", $str_pcat);
					foreach ($arrstr_pcat as $pcat) {
						if ($pcat)
						$where .= ' OR products_category_id LIKE "%,'.$pcat.',%"';
					}
				$where .= '  )';
			}
			switch ($type){
			case 'hit_most':
				$limit_day = 6;
				$where .= '  AND published_time >= DATE_SUB(CURDATE(), INTERVAL '.$limit_day.' DAY) ';	
				break;
			case 'newest':
				$order .= ' ordering DESC,created_time DESC,';
			break;	
			}
			$order .= ' ordering DESC,created_time DESC';
			$query = " SELECT title,alias,image,summary,hits,updated_time,id,category_alias,is_hot,comments_total,content,question,created_time,asker 
						  FROM fs_aq
						 WHERE  published = 1 ".$where."
						 ORDER BY  ".$order."
						 LIMIT $limit  
						 ";
			return $query;
		}
		function get_list($ordering,$limit,$type,$str_pcat){
			global $db;
			$query = $this->setQuery($ordering,$limit,$type,$str_pcat);
			if(!$query)
				return;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}	

		function categories(){
			global $db;
			$query = "SELECT  * FROM fs_aq_categories";
			if(!$query)
				return;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}	
	}
	
?>