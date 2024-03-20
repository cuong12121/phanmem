<?php
	// models 

		  
	class ProductsControllersCategories extends Controllers
	{
		function __construct()
		{
			$this->view = 'categories' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			$list = $this -> model->get_categories_tree();

			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model =  $this -> model;
			$categories = $model->get_categories_tree_all();
			$maxOrdering = $model->getMaxOrdering();
			$tables = $model->get_tablenames();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function edit()
		{
			$model =  $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$data = $model->get_record_by_id($id);
			$categories = $model->get_categories_tree_all();
			$tables = $model->get_tablenames();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}

		function ajax_get_aq_related(){
			$model = $this -> model;
			$data = $model->ajax_get_aq_related();
			$html = $this -> aq_genarate_related($data);
			echo $html;
			return;
		}
		function aq_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
			$html .= '<div class="aq_related">';
			foreach ($data as $item){
				if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
					$html .= '<div class="red aq_related_item  aq_related_item_'.$item -> id.'" onclick="javascript: set_aq_related('.$item->id.')" style="display:none" >';	
					$html .= $item -> title;				
					$html .= '</div>';					
				}else{
					$html .= '<div class="aq_related_item  aq_related_item_'.$item -> id.'" onclick="javascript: set_aq_related('.$item->id.')">';	
					$html .= $item -> title;				
					$html .= '</div>';	
				}
			}
			$html .= '</div>';
			return $html;
		}

		/***********
		 * NEWS RELATED
		 ************/
		function ajax_get_news_related(){
			$model = $this -> model;
			$data = $model->ajax_get_news_related();
			$html = $this -> news_genarate_related($data);
			echo $html;
			return;
		}



		function news_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
				$html .= '<div class="news_related">';
				foreach ($data as $item){
					if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
						$html .= '<div class="red news_related_item  news_related_item_'.$item -> id.'" onclick="javascript: set_news_related('.$item->id.')" style="display:none" >';	
						$html .= $item -> title;				
						$html .= '</div>';					
					}else{
						$html .= '<div class="news_related_item  news_related_item_'.$item -> id.'" onclick="javascript: set_news_related('.$item->id.')">';	
						$html .= $item -> title;				
						$html .= '</div>';	
					}
				}
				$html .= '</div>';
				return $html;
		}


		function ajax_get_videos_related(){
			$model = $this -> model;
			$data = $model->ajax_get_videos_related();
			$html = $this -> videos_genarate_related($data);
			echo $html;
			return;
		}



		function videos_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
				$html .= '<div class="videos_related">';
				foreach ($data as $item){
					if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
						$html .= '<div class="red videos_related_item  videos_related_item_'.$item -> id.'" onclick="javascript: set_videos_related('.$item->id.')" style="display:none" >';	
						$html .= $item -> title;				
						$html .= '</div>';					
					}else{
						$html .= '<div class="videos_related_item  videos_related_item_'.$item -> id.'" onclick="javascript: set_videos_related('.$item->id.')">';	
						$html .= $item -> title;				
						$html .= '</div>';	
					}
				}
				$html .= '</div>';
				return $html;
		}
		/***********
		 * end NEWS RELATED.
		 ************/
		/*
		 * create link edit table name
		 */
		function link_edit_tablename($table_name){
			$table_name = str_replace('fs_products_', '',$table_name);
			$link = 'index.php?module='.$this -> module.'&view=tables&task=edit&tablename='.$table_name;
			return '<a href="'.$link.'" title="Sửa bảng" >'.$table_name.'</a>';
		}
		function view_genarate_filter($data){
			$table_name = str_replace('fs_products_', '',$data -> tablename);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view.'&task=genarate_filter&tablename='.$table_name;
			return '<a href="'.$link.'" title="Tính toán lại bộ lọc" >Tính lại bộ lọc</a>';
		}
		
		function link_import($id){
			$link = 'index.php?module='.$this -> module.'&view=import&cid='.$id;
			return '<a href="'.$link.'" title="Sửa bảng" ><img src="templates/default/images/toolbar/icon-import.png" /> </a>';
		}
		/*
		 * Sinh ra bộ lọc tự động
		 */
		function genarate_filter($row = array()){
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$table_name = FSInput::get('tablename');
			if(!$table_name){
				setRedirect($link,FSText :: _('Không được để trống bảng mở rộng'));	
			}
			$table_name = 'fs_products_'.$table_name;
			$model = $this -> model;
			$rs = $model->caculate_filter(array($table_name));
			
			if($this -> page)
				$link .= '&page='.$this -> page;	
			if($rows){
				setRedirect($link,$rows.' '.FSText :: _('Đã tính lại xong bộ lọc'));	
			} else {
				setRedirect($link,FSText :: _('Không tính được'),'error');	
			}
		}

		function show_in_menu()
			{
			$model = $this -> model;
			$rows = $model->show_in_menu(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was event'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when hot record'),'error');	
			}
		}
		function unshow_in_menu()
		{
			$model = $this -> model;
			$rows = $model->show_in_menu(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was un_hot'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when un_hot record'),'error');	
			}
		}

		function ajax_get_categories(){
			$model = $this -> model;
			$id_move = FSInput::get('id_move');
			if(!$id_move){
				return false;
			}
			$data = $model->get_record('id = ' . $id_move,'fs_products_categories');
			$list = $model->get_records('tablename = "'.$data->tablename.'"','fs_products_categories');
			if(!empty($list)){
				echo $get_menu_tree = $this->get_menu_tree(0,$data->tablename);
				return;
			}
		}

		function get_menu_tree($parent_id,$tablename) 
		{
			$model = $this -> model;
			$menu = "";
			$list = $model->get_records('published = 1 AND tablename ="'.$tablename.'" AND parent_id =' . $parent_id, 'fs_products_categories','*','name ASC ');
			if(!empty($list)){
				foreach ($list as $key => $item) {
					$link = 'javascript:void(0)';
					$menu .="<li class='level".$item ->level."'>" ;
					$menu .="<a class='menu_a_".$item ->id."' onclick='javascript:set_id_move_to(".$item ->id.")' href='".$link."'>".$item ->name."</a>";
				    $menu .= "<ul class='sub-menu'>".$this->get_menu_tree($item ->id,$tablename)."</ul>";
		 		    $menu .= "</li>";
				}
			}
		    return $menu;
		}

		function ajax_move_category(){
			$model = $this -> model;
			$move = $model->ajax_move_category();
			echo $move;
			return;
		}


		function ajax_get_manufactory_related(){
			$model = $this -> model;
			$data = $model->ajax_get_manufactory_related();
			$html = $this -> manufactory_genarate_related($data);
			echo $html;
			return;
		}
		
		function manufactory_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
				$html .= '<div class="manufactory_related">';
				foreach ($data as $item){
					if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
						$html .= '<div class="red manufactory_related_item  manufactory_related_item_'.$item -> id.'" onclick="javascript: set_manufactory_related('.$item->id.')" style="display:none" >';	
						$html .= $item -> name;				
						$html .= '</div>';					
					}else{
						$html .= '<div class="manufactory_related_item  manufactory_related_item_'.$item -> id.'" onclick="javascript: set_manufactory_related('.$item->id.')">';	
						$html .= $item -> name;				
						$html .= '</div>';	
					}
				}
				$html .= '</div>';
				return $html;
		}

		function ajax_get_types_compatable(){
			$product_id = FSInput::get('product_id');
			$model = $this -> model;
			$types_compatables = $model->get_records('published = 1','fs_products_types_compatables','*');
			$html = '';
			$html .= '<select name="types_compatables_'.$product_id.'">';
			foreach ($types_compatables as $types) {
				$html .= '<option value="'.$types-> id.'">'.$types-> name.'</option>';
			}
			$html .= '</select>';
			echo $html;
			return;
		}

		function ajax_get_products_compatable(){
			$model = $this -> model;
			$data = $model->ajax_get_products_compatable();
			$html = $this -> products_genarate_compatable($data);
			echo $html;
			return;
		}
		function products_genarate_compatable($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
			$html .= '<div class="products_compatable">';

			foreach ( $data as $item ) {
			
				if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->id . ',' ) !== false) {
					$html .= '<div class="red products_compatable_item  products_compatable_item_' . $item->id . '" onclick="javascript: set_products_compatable(' . $item->id . ')" style="display:none" >';
				} else {
					$html .= '<div class="products_compatable_item  products_compatable_item_' . $item->id . '" onclick="javascript: set_products_compatable(' . $item->id . ')">';
				}
				$html .= $item->name;
				
				$html .= '</div>';
			}

			$html .= '</div>';
			return $html;

		}

		function ajax_get_seo_manu(){
			$model = $this -> model;
			$data = $model->ajax_get_seo_manu();
			$html = $this -> seo_manu_genarate($data);
			echo $html;
			return;
		}
		function seo_manu_genarate($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
			$html .= '<div class="seo_manu">';

			foreach ( $data as $item ) {
			
				if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->id . ',' ) !== false) {
					$html .= '<div class="red seo_manu_item  seo_manu_item_' . $item->id . '" onclick="javascript: set_seo_manu(' . $item->id . ')" style="display:none" >';
				} else {
					$html .= '<div class="seo_manu_item seo_manu_item_' . $item->id . '" onclick="javascript: set_seo_manu(' . $item->id . ')">';
				}
				$html .= $item->name;
				
				$html .= '</div>';
			}

			$html .= '</div>';
			return $html;

		}
	}

	function view_move_product($controle,$id) {
		$model = $controle -> model;
		$check_parent = $model->get_record('parent_id = ' .$id ,'fs_products_categories');
		if(empty($check_parent)){
			return '<a href="javascript:void(0)" onclick="javascript:set_id_move('.$id.')" style="
			    background: #007cff;
			    display: inline-block;
			    padding: 5px 13px;
			    border-radius: 5px;
			    color: #FFF;
			    font-weight: bold;
			    margin-right: 10px;
			    margin-top: 10px;
			">Chuyển</a>';
		}
	}


	
?>