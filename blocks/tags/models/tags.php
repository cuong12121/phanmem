<?php 
	class TagsBModelsTags
	{
		function __construct()
		{
		}
		function getList(){
//			global $tags_group;
			$where = '';
//			if($tags_group){
//				 $where .= ' AND ( category_ids like  "%,'.$tags_group.',%"';
//                    $where .= ' OR category_ids like  "%,'.$tags_group.'"';
//                    $where .= ' OR category_ids like  "'.$tags_group.',%"';
//                    $where .= ' OR category_ids =  "'.$tags_group.'" )';
//			} else {
//				$where .= ' AND is_common = 1';
//			}
			global $db ;
			$limit = 150;
			$sql = " SELECT id, name, level, alias,is_bold,link
					FROM fs_tags
					WHERE published  = 1 ".$where." 
					ORDER BY ordering
					LIMIT $limit ";
			$db->query($sql);
			$list =  $db->getObjectList();
//			$str_id = '';
//			$total = count($list);
//			for($i = 0; $i < $total; $i ++){
//				if($i>0)
//				    $str_id .= ',';
//				$str_id .= $list[$i]->id;
//			}
//			$where2 = '';
//			if($str_id)
//			 $where2 .= " AND id NOT IN (".$str_id.") ";
//			if(($total < $limit) && $tags_group){
//				$limit2 = $limit - $total;
//				$sql2 = " SELECT id, name, level, alias
//                    FROM fs_tags_".$lang."
//                    WHERE published  = 1 
//                    AND is_common = 1 
//                    ".$where2."
//                    ORDER BY rand()
//                    LIMIT $limit2 ";
//				$db->query($sql2);
//				$list2 =  $db->getObjectList();
//				$i = $total;
//	            if(count($list2)){
//	                foreach($list2 as $item){
//	                    $list[$i] = $item;
//	                    $i++;
//	                }
//	            }
//			}
			
			return $list;
		}
		
	}
	
?>