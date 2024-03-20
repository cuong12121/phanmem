<?php
/*
 * Huy write
 */
	// models 
	include 'modules/menus/models/admin.php';
	
	class MenusControllersAdmin
	{
		function __construct()
		{
			$module = 'menus';
			$this -> module = $module ;
		}
		function display()
		{
			// call models
			$model = new MenusModelsAdmin();
			$list = $model->getMenusAdmin();
			$permissions = $model->user_permission();
			$menus = array();
			foreach($list as $item){
				// if($this -> check_link_permission($item -> module,$item -> link,$permissions)){
					$menus[] =  $item;
				// }
			}

			include_once '../libraries/tree/tree.php';
			$list = Tree::indentRows($menus);

			
			// dd($arr_per_md);
			// printr($group_data);
			
			// call views
			// $user_id = $_SESSION['ad_userid'];
			// if(!empty($list) || $user_id == 9){
				include 'modules/menus/views/admin/default.php';
			// }


			
			
		}
		
		function check_link_permission($module,$link,$permissions){
			if(!$module){
				if(!$link){
					return true;
				}else{
					preg_match('#module=([^&]*)#is',$link,$item);
					$module = @$item[1];
				}
			}
			if(!$link){
				$view = $module;
			}else{
				preg_match('#view\=([^&]*)#is',$link,$item);
				$view = @$item[1];
			}
			if(!$view)
				$view = $module;
			if(!isset($permissions[$module][$view]))
					return true;
			if($permissions[$module][$view])
				return true;
			return false;
		}
	
		function showMenu($level=1,$parent = 0,$start_level=0,$end_level=0,$params)
		{
			$rs = "";
			$list = JvpdMenuHelpler::getCategory($params);
			$Itemid = JvpdMenuHelpler::getItemIdJvProduct();
			$i = 0;
			$len =0;
	//		$length = count($list);
	//		echo $length;
	
			foreach ( $list as $item )
			{ 
				if($item->level == $level && $item->parent_id == $parent )
				{
					$len++;
				}
			}
			
			foreach ( $list as $item ) {
	        	if($item->level == $level && $item->parent_id == $parent )
	        	{
	        		// class type: last and first
	        		$class_type="";
	        		if($i==0)
	        		{
	        			$class_type .= " jv_first_item";
	        		}
	        		if(($i+1)==$len)
	        		{
	        			$class_type .= " jv_last_item";
	        		}
	        		if($i!=0 && ($i+1)!=$len)
	        		{
	        			$class_type = "";
	        		}
	        		
	        		// level
	        		$condition1 = false;
	        		$condition2 = false;
	        		if(($start_level && $item->level>=$start_level )||(!$start_level)) 
	        		{
	        			$condition1 =   1;
	        		}
	        		if(($end_level && $item->level<=$end_level )||(!$end_level)) 
	        		{
	        			$condition2 =   1;
	        		}
	        		if($condition1 &&  $condition2)
	        		{
		        		$link = JRoute::_("index.php?option=com_jv_product&view=category&cid=".$item->id."&Itemid=".$Itemid."");
		        		
		        		// Begin check current link:
		        		$current_class=	"";
		        		if(JRequest::getVar('option','') == 'com_jv_product'
		        			&& JRequest::getVar('view','') == 'category'
		        			&& JRequest::getVar('cid',0) == $item->id
		        			&& JRequest::getVar('Itemid') == $Itemid	        			
		        		)
	        			{
	        				$current_class=	"current";
	        			}
		        		// End check current link.
		        		
		        		
		        		if($item->children &&  (($end_level && $item->level<$end_level) || !$end_level) )
		        		{
		        			$rs .= "<li id=\"item$item->id\" level=\"$item->level\" access=\"$item->access\" class=\"hasChild $class_type $current_class item$item->id\" >";
		        			$rs .= "		<a href=\"$link\"><span>".$item->name."</span>";
		        			$rs .= "<span class=\"span_hasChild\"></span></a> "	;
		        		}
		        		else
		        		{
		        			$rs .= "<li id=\"item$item->id\" level=\"$item->level\" access=\"$item->access\"  class=\"$class_type $current_class item$item->id\">";
		        			$rs .= "		<a href=\"$link\"><span>".$item->name."</span></a>";
		        		}
		        		
	        		}
	        		
	        	
	        		
	        		if($item->children)
	        		{	
	        			if((($item->level)+1)==$start_level)
	        			{
	        				$rs .= JvpdMenuHelper::showMenu(($item->level)+1,$item->id,$start_level,$end_level,$params);
	//        				echo "<ul>";
	        			}
	        			else
	        			{
	//        				$rs .= "<ul style=\"display: none; visibility: hidden;\">";
	        				$rs .= "<ul>";
	        				$rs .= JvpdMenuHelpler::showMenu(($item->level)+1,$item->id,$start_level,$end_level,$params);
	        				$rs .= "</ul>";
	        			}
	        			
	        			
	        		}
	        		$i++;
	        		$rs .= "</li>";
	        	}
				
	        }	
	        return $rs;	
	     	
		}
	}
	
?>