<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/mainmenu/models/mainmenu.php';
	
	class MainMenuBControllersMainMenu extends FSControllers
	{
		function __construct()
		{
		}
		function display($parameters,$title){
			$group = $parameters->getParams('group');
			$style = $parameters->getParams('style');
			$style = $style?$style:'default';
//			$group = isset($parameters['group']) ? $parameters['group'] : '1';
//			$style = isset($parameters['style']) ? $parameters['style'] : 'default';

			$group2 = $parameters->getParams('group2');
			$arr_group = $parameters->getParams('arr_group');

			if(!$group)	
				return;
			// call models
			$model = new MainMenuBModelsMainMenu();


			// $module = FSInput::get('module');
			$cid_cat = FSInput::get('cid');
			if($cid_cat){
				$list_submenu = $model->getListSubmenu($cid_cat);
			}

			$list_submenu_new = $model->getListSubmenuNew();

			if($style == 'submenuaq'){
				$list_submenu = $model->getListSubmenu();
				$ccode = FSInput::get('ccode');

				foreach ($list_submenu as $sub_menu) {
					$sub_menu-> active = 0;
					if(!empty($ccode) ){
						if($ccode == $sub_menu-> alias) {
							$sub_menu-> active = 1;					
						}
					}else {
						$check = $model->active_sub($sub_menu->id);
						if($check){
							$sub_menu-> active = 1;
						}
					}
				}
			}


			//$check_ac = $model->active_sub();
			

			//$active_cat_sub = $model->active_sub();


			
			$list = $model->getList($group);
			$list_cat = $model->getListCat();

			if($style == 'drop_down'){
				$level_0 = array();
				$level_1 = array();
				$level_2 = array();

				foreach ($list as $item) {
					if($item-> level == 0){
						$level_0[] = $item;
					}
				}
				

				foreach ($level_0 as $lv0) {
					$list_lv1 = $model -> get_menu_parent($lv0->id,$group);
					$level_1[$lv0->id] = $list_lv1;
				}


				foreach ($level_1 as $lv1s) {
					if(empty($lv1s)){
						continue;
					}
					
					foreach ($lv1s as $lv1) {
						$list_lv2 = $model -> get_menu_parent($lv1->id,$group);
						$level_2[$lv1->id] = $list_lv2;
					}
				}		
			}
			

		if(!$list)
			return;
		$arr_activated = array();
		
		$module = FSInput::get('module');
		$id = FSInput::get('cid');

		if($module == 'products') {
			$arr_activated['c'.$id] = 1;
			
		}
		if(!count($list))
			return;
		if($style == 'megamenu' || $style == 'megamenu2' || $style == 'menu_header'  || $style == 'amp' ){

		
			$level_0 = array();
			$children = array();
			$banner_0 = array();	
				//$arr_activated = array();
			
			foreach ($list as $item) {
				$arr_activated[$item->id] = 0;
				
				if(!$item -> parent_id){
					$level_0[] = $item;
					if($item->banner_id ){ 
						$list_banner =  $model -> get_records('category_id = '.$item->banner_id . " AND published = 1",'fs_banners','id,name,image,link','ordering ASC, id ASC','2');					
						$banner_0[$item->id] = $list_banner;					
					}
				}else{
					if(!isset($children[$item -> parent_id]))
						$children[$item -> parent_id] = array();
						$children[$item -> parent_id][] = $item;
				}			
					// check ativated
					$activated  = $this -> check_active($item -> link);
					if($activated){
						$arr_activated[$item->id] = 1;
						if(isset($item -> parent_id) && !empty($item -> parent_id) )
							$arr_activated[$item -> parent_id] = 1;
					}
				}
			}
			
			
			foreach($list as $item){
				$arr_activated[$item->id] = 0;			
				// check ativated
				$activated  = $this -> check_activated($item -> link);
				if($activated){
					$arr_activated[$item->id] = 1;
					if(isset($item -> parent_id) && !empty($item -> parent_id) )
						$arr_activated[$item -> parent_id] = 1;
				}
			}



			if($style == 'megamenu_mb' || $style == 'megamenu_mb2'){
				//$get_menu_tree_mobile = ''; 
				$html = '';
				$html2 = '';
				global $config;
				if(@$_COOKIE['user_id']) {
					$html .= '<li class="level_0"><a href="'.URL_ROOT.'thong-tin-tai-khoan.html"><div class="svg">'.$config['icon_user'].'</div>Tài khoản</a></li>';
				} else {
					$html .= '<li class="level_0"><a href="'.URL_ROOT.'dang-nhap.html"><div class="svg">'.$config['icon_user'].'</div>Đăng nhập</a></li>';
				}
				if($group2){
					$html = '';
					$html .= "<li class = 'level_0 ' id = 'menu_0'><span>Tất cả danh mục</span>";
					$html .= "<span class = 'next_menu' id ='next_0'></span>";
					$html .= "<ul class = 'highlight highlight_1 scroll_bar' id = 'sub_menu_0'>";
					$html .= "<div class = 'label' id = 'close_0'>Danh mục</div>";
					$html .= $this-> get_menu_tree_mobile2(0,$group2);
					$html .= "</ul>";
					$html .= "</li>";					
				}

				$get_menu_tree_mobile = $this-> get_menu_tree_mobile(0,$group,1);
				$html .= $get_menu_tree_mobile ;


				if($arr_group){
					if(strpos($arr_group, '(') !== false){
						$html2 .=  $this-> get_menu_tree_mobile3(0,$arr_group);
					}else{
						$arr_group = explode(',',$arr_group);
						foreach ($arr_group as $it) {
							$html2 .=  $this-> get_menu_tree_mobile(0,$it);
						}
					}		
				}
				$html .= $html2 ;
			}

				
			if($style == 'megamenu_pro_mb'){
				$html = '';
				$html2 = '';
				//if($group2){
					
				$html .= "<li class = 'level_0 ' id = 'menu_0'><span>Tất cả danh mục</span>";
				$html .= "<span class = 'next_menu' id ='next_0'></span>";
				$html .= "<ul class = 'highlight highlight_1 scroll_bar' id = 'sub_menu_0'>";
				$html .= "<div class = 'label' id = 'close_0'>Danh mục</div>";
				$html .= $this-> get_menu_tree_mobile_pro(0);
				$html .= "</ul>";
				$html .= "</li>";

				//}

				$get_menu_tree_mobile = $this-> get_menu_tree_mobile(0,$group);
				
				$html .= $get_menu_tree_mobile ;

				if($arr_group){
					if(strpos($arr_group, '(') !== false){
						$html2 .=  $this-> get_menu_tree_mobile3(0,$arr_group);
					}else{
						$arr_group = explode(',',$arr_group);
						foreach ($arr_group as $it) {
							$html2 .=  $this-> get_menu_tree_mobile(0,$it);
						}
					}		
				}
				$html .= $html2 ;

			}	
			
			// call views
			include 'blocks/mainmenu/views/mainmenu/'.$style.'.php';
		}

		function get_menu_tree_mobile($parent_id,$group,$all=0) 
		{
			$menu = "";
			$model = new MainMenuBModelsMainMenu();

			if($all) {
				$list = $model->get_records('published = 1 AND group_id = ' . $group , 'fs_menus_items','*','ordering');
			} else {
				$list = $model->get_records('parent_id =' . $parent_id . ' AND published = 1 AND group_id = ' . $group , 'fs_menus_items','*','ordering');
			}
			
			

			if(!empty($list)){
				foreach ($list as $key => $item) {
					$link = FSRoute::_($item ->link);

					$level = $item-> level + 1;
					//echo $item-> level;
					$menu .="<li class = 'level_".$item->level."'>";
					$menu .="<a href='".$link."'><div class='svg'>".$item ->icon.'</div>'.$item ->name."</a>";

					$list_check = $model-> get_records('parent_id =' . $item ->id . ' AND published = 1 AND group_id = ' . $group , 'fs_menus_items','*','ordering');

					if(!empty($list_check)){
						$menu .= "<span class = 'next_menu' id ='next_".$item->id."'></span>";
						//$level = $item-> level + 1;						
				    	$menu .= "<ul class = 'highlight highlight_".$level." scroll_bar' id = 'sub_menu_".$item->id."'>";
				    	$menu .= "<div class = 'label' id = 'close_".$item->id."'>".$item ->name."</div>";
				    	$menu .=$this->get_menu_tree_mobile($item -> id,$group);
				    	$menu .= "</ul>";
					}
		 		    $menu .= "</li>";
				}
			}
		    return $menu;
		}

		function get_menu_tree_mobile2($parent_id,$group) 
		{
			$menu = "";
			$model = new MainMenuBModelsMainMenu();

			$list = $model->get_records('parent_id =' . $parent_id . ' AND published = 1 AND group_id = ' . $group , 'fs_menus_items','*','ordering');
			
			if(!empty($list)){
				foreach ($list as $key => $item) {
					$link = FSRoute::_($item ->link);

					$list_check = $model->get_records('parent_id =' . $item ->id . ' AND published = 1 AND group_id = ' . $group , 'fs_menus_items','*','ordering');
					if(!empty($list_check)){
						$no_next = 'continue';
					}else{
						$no_next = '';
					}

					$level = $item-> level + 1;
					$menu .="<li class = 'level_".$level.' '. $no_next. "'>";
					$menu .="<a href='".$link."'><div class='svg'>".$item ->icon.'</div>'.$item ->name."</a>";

					
					if(!empty($list_check)){
						$menu .= "<span class = 'next_menu' id ='next_".$item->id."'></span>";
						$level2 = $item-> level + 2;						
				    	$menu .= "<ul class = 'highlight highlight_".$level2." scroll_bar' id = 'sub_menu_".$item->id."'>";
				    	$menu .= "<div class = 'label' id = 'close_".$item->id."'>".$item ->name."</div>";
				    	$menu .= $this->get_menu_tree_mobile2($item ->id,$group);
				    	$menu .= "</ul>";
					}

		 		    $menu .= "</li>";	 		   
				}
			}
		    return $menu;
		}

		function get_menu_tree_mobile3($parent_id,$group) 
		{
			$menu = "";
			$model = new MainMenuBModelsMainMenu();

			$list = $model->get_records('parent_id =' . $parent_id . ' AND published = 1 AND group_id IN ' . $group , 'fs_menus_items','*','ordering');

			if(!empty($list)){
				foreach ($list as $key => $item) {
					$link = FSRoute::_($item ->link);

					$level = $item-> level + 1;
					//echo $item-> level;
					$menu .="<li class = 'level_".$item->level."'>";
					$menu .="<a href='".$link."'>".$item ->icon.$item ->name."</a>";

					$list_check = $model-> get_records('parent_id =' . $item ->id . ' AND published = 1 AND group_id IN ' . $group , 'fs_menus_items','*','ordering');

					if(!empty($list_check)){
						$menu .= "<span class = 'next_menu' id ='next_".$item->id."'></span>";
						//$level = $item-> level + 1;						
				    	$menu .= "<ul class = 'highlight highlight_".$level." scroll_bar' id = 'sub_menu_".$item->id."'>";
				    	$menu .= "<div class = 'label' id = 'close_".$item->id."'>".$item ->name."</div>";
				    	$menu .=$this->get_menu_tree_mobile3($item -> id,$group);
				    	$menu .= "</ul>";
					}
		 		    $menu .= "</li>";
				}
			}
		    return $menu;
		}

		function get_menu_tree_mobile_pro($parent_id) 
		{
			$menu = "";
			$model = new MainMenuBModelsMainMenu();

			$list = $model->get_records('parent_id =' . $parent_id . ' AND published = 1' , 'fs_products_categories','*','ordering');
			//print_r($list);
			
			if(!empty($list)){
				foreach ($list as $key => $item) {

					//$link = FSRoute::_($item ->link);
					$link = FSRoute::_("index.php?module=products&view=cat&ccode=".$item -> alias."&cid=".$item->id);
					$list_check = $model->get_records('parent_id =' . $item ->id . ' AND published = 1 ' , 'fs_products_categories','*','ordering');
					if(!empty($list_check)){
						$no_next = 'continue';
					}else{
						$no_next = '';
					}

					$level = $item-> level + 1;
					$menu .="<li class = 'level_".$level.' '. $no_next. "'>";
					$menu .="<a href='".$link."'>".$item ->icon.$item ->name."</a>";

					
					if(!empty($list_check)){
						$menu .= "<span class = 'next_menu' id ='next_".$item->id."'></span>";
						$level2 = $item-> level + 2;						
				    	$menu .= "<ul class = 'highlight highlight_".$level2." scroll_bar' id = 'sub_menu_".$item->id."'>";
				    	$menu .= "<div class = 'label' id = 'close_".$item->id."'>".$item ->name."</div>";
				    	$menu .= $this->get_menu_tree_mobile_pro($item ->id);
				    	$menu .= "</ul>";
					}

		 		    $menu .= "</li>";	 		   
				}
			}
		    return $menu;
		}
		
	/*
		 * get Array params
		 */
		function get_params($url){
			$url_reduced  = substr($url,10); // width : index.php
			$array_buffer = explode('&',$url_reduced,10);
			$array_params = array();
			for($i  = 0; $i < count($array_buffer) ; $i ++ ){
				$item = $array_buffer[$i];
				$pos_sepa = strpos($item,'=');
				$array_params[substr($item,0,$pos_sepa)] = substr($item,$pos_sepa+1);  
			}
			return $array_params;
		}
		function check_active($link=''){
			$link_rewrite = FSRoute::_($link)."--";
			$url_current = URL_ROOT.substr($_SERVER['REQUEST_URI'],1);
			
			if($link_rewrite == $url_current)
				return true;
			$module = FSInput::get('module');
			$view = FSInput::get('view');
			if($module == 'news' && ($view=='news' || $view == 'cat')){
				$ccode = FSInput::get('ccode');
				if(strpos($link,'&ccode='.$ccode ) !== false){
					return true;
				}
			}
			return false;
		}

		function check_active_cat($alias=''){
			//$link_rewrite = FSRoute::_($link)."--";
			//$url_current = URL_ROOT.substr($_SERVER['REQUEST_URI'],1);
			
			// if($link_rewrite == $url_current)
			// 	return true;
			$module = FSInput::get('module');
			$view = FSInput::get('view');
			if($module == 'products' && ($view=='products' || $view == 'cat')){
				$ccode = FSInput::get('ccode');
				if($alias==$ccode ){
					return true;
				}
			}
			return false;
		}
		function check_activated($url){
			if(!$url)
				return false;
			$array_params  = $this ->  get_params($url);
			$module  = isset($array_params['module'])?$array_params['module']: '';
			$module_c = FSInput::get('module');
			$module_c."_ccccccccc";

			if($module != $module_c)
				return false;
			switch ($module){
				case 'poll':
				case 'projects':
				case 'designs':
				case 'contact':
				case 'videos':
				case 'goals':
				case 'gallery':
				case 'partners':
				case 'ranks':
					if($module == $module_c)
						return true;
					return false;
					
				case 'news':
					$view  = isset($array_params['view'])?$array_params['view']: $module;					
					$view_c = FSInput::get('view');
					switch ($view){
						case 'news':
							if($view != $view_c)
								return false;
							$code  = isset($array_params['code'])?$array_params['code']:'';
							$code_c = FSInput::get('code');
							if($code == $code_c)
								return true;
							return false;
						case 'cat':
							$ccode  = isset($array_params['ccode'])?$array_params['ccode']:'';
							$ccode_c = FSInput::get('ccode');
							if(!empty($ccode) && $ccode_c == $ccode )
								return true;
							return false;
						case 'home':
							return true;
							// $ccode_c = FSInput::get('ccode');
							// return $ccode_c == 'tu-van'?false:true;
						default:
							return $view ==  $view_c ? true:false;
					}
				case 'contents':
					$view  = isset($array_params['view'])?$array_params['view']: $module;
					$view_c = FSInput::get('view');
					switch ($view){
						case 'contents':
							if($view != $view_c)
								return false;
							$code  = isset($array_params['code'])?$array_params['code']:'';
							$code_c = FSInput::get('code');
							if($code == $code_c)
								return true;
							return false;
						case 'cat':
							$ccode  = isset($array_params['ccode'])?$array_params['ccode']:'';
							$ccode_c = FSInput::get('ccode');
							if(!empty($ccode) && $ccode_c == $ccode )
								return true;
							return false;
						case 'home':
							return true;
						default:
							return $view ==  $view_c ? true:false;
					}
				case 'products':
					$view  = isset($array_params['view'])?$array_params['view']: $module;
					$view_c = FSInput::get('view');
					switch ($view){
						case 'product':
							if($view != $view_c)
								return false;
							$code  = isset($array_params['code'])?$array_params['code']:'';
							$code_c = FSInput::get('code');
							if($code == $code_c)
								return true;
							return false;
						case 'cat':
							$ccode  = isset($array_params['ccode'])?$array_params['ccode']:'';
							$ccode_c = FSInput::get('ccode');
							if(!empty($ccode) && $ccode_c == $ccode )
								return true;
							return false;
						case 'types':
						 $ccode  = isset($array_params['ccode'])?$array_params['ccode']:'';

						 $ccode_c = FSInput::get('ccode');

						if(!empty($ccode) && $ccode_c == $ccode )
							return true;
						return false;
						case 'home':
							return true;
						default:
							return $view ==  $view_c ? true:false;
					}
				return false;
			}
		}
	}
	
?>