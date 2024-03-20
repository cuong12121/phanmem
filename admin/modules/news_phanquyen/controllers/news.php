<?php
	class NewsControllersNews extends Controllers
	{
		function __construct()
		{
			$this->view = 'news' ; 
			parent::__construct();

			$array_status = array( 0 => 'Lưu nháp',1 => 'Xuất bản',2=>'Trả bài',3=>'Gửi cho TBT duyệt',4 => 'Hạ bài');
			
			$this -> array_status = $array_status;
		}

		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			
			$list = $model->get_data();
			
			
			$categories = $model->get_categories_tree();
			$array_status = $this -> array_status;
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function add()
		{	
			$model = $this -> model;
			
			$array_status = array( 0 => 'Lưu nháp',3=>'Gửi cho TBT duyệt');
			$categories = $model->get_categories_tree();
			$author = $model -> get_author();
			// data from fs_news_categories
			$categories_home  = $model->get_categories_tree();
			$maxOrdering = $model->getMaxOrdering();
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$model = $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$check_group = $model->get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($check_group->group_id == 2 || $_SESSION['ad_userid'] == 9 ){
				
				$data = $model->get_record('id = ' . $id . ' AND published !=0','fs_news');
				if(empty($data)){
					setRedirect('index.php?module='.$this->module.'&view='.$this->view,'Bài viết không tồn tại');
				}
				
			}else{
				
				$data = $model->get_record('id = ' . $id .' AND creator_id = ' . $_SESSION['ad_userid'],'fs_news');
				
				if(empty($data)){
					setRedirect('index.php?module='.$this->module.'&view='.$this->view,'Bài viết không tồn tại');
				}
			}
			

			$array_status_all = $this->array_status;

			
			if($check_group->group_id == 2 || $_SESSION['ad_userid'] == 9){
				
			}else{
				if($data ->published == 1 || $data ->published == 3 || $data ->published == 4){
					setRedirect('index.php?module='.$this->module.'&view='.$this->view,'Bài này đang trong trạng thái '. $array_status_all[$data ->published] . ' nên không sửa được');
				}
			}
			
			if($check_group->group_id == 2 || $_SESSION['ad_userid'] == 9){
				$array_status = array( 1 => 'Xuất bản',2=>'Trả bài',3=>'Gửi cho TBT duyệt',4 => 'Hạ bài');
			}else{
				if($data ->published == 2){
					$array_status = array( 0 => 'Lưu nháp',2=>'Trả bài',3=>'Gửi cho TBT duyệt');
				}else{
					$array_status = array( 0 => 'Lưu nháp',3=>'Gửi cho TBT duyệt');
				}
			}

			$categories  = $model->get_categories_tree();
			$author = $model -> get_author();
//			$tags_categories = $model->get_tags_categories();
			
			if($data -> current_userid && $data -> current_userid != $_SESSION['ad_userid'] ){
				// delay 600 second
				if($data -> view_last_time > (time()-600) ){
					$user_full_name_current = $model -> get_user_by_id($data -> current_userid);
					setRedirect('index.php?module='.$this->module.'&view='.$this->view,'Tài khoản <strong>'.$user_full_name_current.'</strong> đang sửa bài "'.$data -> title.'", bạn hãy trở lại sau','error');
				//				return;
				}
			}
			// đánh dấu đang đọc
			$model -> assign_editing($data -> id);


			// news related
			$products_categories = $model->get_products_categories_tree();
			$products_related = $model -> get_products_related($data -> products_related);
			
			// news related
			$news_categories = $model->get_news_categories_tree();
			// $news_related = $model -> get_news_related($data -> news_related);
			
			// data from fs_news_categories
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}

		function cancel()
		{
			$id = FSInput::get('id',0,'int');
			$model  = $this -> model;
			$model -> assign_without_editing($id);
			$module = FSInput::get('module');
			$view = FSInput::get('view');
			unset($_SESSION[$module][$view]);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			if($this -> page)
				$link .= '&page='.$this -> page;	
			setRedirect($link);	
		}
		function back()
		{
			$id = FSInput::get('id',0,'int');
			$model  = $this -> model;
			$model -> assign_without_editing($id);
			$module = FSInput::get('module');
			$view = FSInput::get('view');
			unset($_SESSION[$module][$view]);
			$page = FSInput::get('page',0,'int');
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			if($this -> page)
				$link .= '&page='.$this -> page;	
			setRedirect($link);	
		}

		function remove()
		{

			$model = $this -> model;
			
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$data = $model->get_record('id = ' . $id,'fs_news');
			$array_status_all = $this->array_status;
			if($data ->published == 1 || $data ->published == 3 || $data ->published == 4){
				setRedirect('index.php?module='.$this->module.'&view='.$this->view,'Bài này đang trong trạng thái '. $array_status_all[$data ->published] . ' nên không Xóa được');
			}

			$rows = $model->remove();
			if($rows)
			{
				setRedirect('index.php?module='.$this -> module.'&view='.$this -> view,$rows.' '.FSText :: _('record was deleted'));	
			}
			else
			{
				setRedirect('index.php?module='.$this -> module.'&view='.$this -> view,FSText :: _('Not delete'),'error');	
			}
		}
		
		function view_comment($new_id){
			$link = 'index.php?module=news&view=comments&keysearch=&text_count=1&text0='.$new_id.'&filter_count=1&filter0=0';
			return '<a href="'.$link.'" target="_blink">Comment</a>'; 
		}
		function view_history($new_id) {
			$link = 'index.php?module=news&view=history&news_id=' . $new_id;
			return '<a href="' . $link . '" target="_blink"><img border="0" src="templates/default/images/clock_red.png" alt="History"></a>';
		}
		function is_hot()
	{
		$model = $this -> model;
		$rows = $model->hot(1);
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
	function unis_hot()
	{
		$model = $this -> model;
		$rows = $model->hot(0);
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
		function is_promotion()
		{
			$model = $this -> model;
			$rows = $model->promotion(1);
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
		function unis_promotion()
		{
			$model = $this -> model;
			$rows = $model->promotion(0);
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
		function is_instalment()
		{
			$model = $this -> model;
			$rows = $model->instalment(1);
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
		function unis_instalment()
		{
			$model = $this -> model;
			$rows = $model->instalment(0);
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
		function is_ask()
		{
			$model = $this -> model;
			$rows = $model->ask(1);
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
		function unis_ask()
		{
			$model = $this -> model;
			$rows = $model->ask(0);
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
		function ajax_get_products_related(){
			$model = $this -> model;
			$data = $model->ajax_get_products_related();
			$html = $this -> products_genarate_related($data);
			echo $html;
			return;
		}
		function products_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
				$html .= '<div class="products_related">';
				foreach ($data as $item){
					if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
						$html .= '<div class="red products_related_item  products_related_item_'.$item -> id.'" onclick="javascript: set_products_related('.$item->id.')" style="display:none" >';	
						$html .= $item -> name;				
						$html .= '</div>';					
					}else{
						$html .= '<div class="products_related_item  products_related_item_'.$item -> id.'" onclick="javascript: set_products_related('.$item->id.')">';	
						$html .= $item -> name;				
						$html .= '</div>';	
					}
				}
				$html .= '</div>';
				return $html;
		}
		/*
		 *==================== AJAX RELATED PRODUCTS==============================
		 */
	
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
		function remove_cache() {

			$model = $this -> model;
		
			$rows = $model->remove_cache();

			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows){
				setRedirect($link,FSText :: _('Bạn đã xóa cache thành công'));	
			}
		
		}



		function view_fontend($data) {
			if($data -> published){
				$link = FSRoute::_('index.php?module=news&view=news&id='.$data->id.'&code='.$data -> alias.'&ccode='.$data-> category_alias);
				return '<a target="_blink" href="' . $link . '"><svg height="32px" version="1.1" viewBox="0 0 32 32" width="32px" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"><title/><desc/><defs/><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="#157EFB" id="icon-22-eye"><path d="M17,9 C8,9 4,16 4,16 C4,16 8,23.000001 17,23 C26,22.999999 30,16 30,16 C30,16 26,9 17,9 L17,9 Z M17,20 C19.2091391,20 21,18.2091391 21,16 C21,13.7908609 19.2091391,12 17,12 C14.7908609,12 13,13.7908609 13,16 C13,18.2091391 14.7908609,20 17,20 L17,20 Z M17,19 C18.6568543,19 20,17.6568543 20,16 C20,14.3431457 18.6568543,13 17,13 C15.3431457,13 14,14.3431457 14,16 C14,17.6568543 15.3431457,19 17,19 L17,19 Z M17,17 C17.5522848,17 18,16.5522848 18,16 C18,15.4477152 17.5522848,15 17,15 C16.4477152,15 16,15.4477152 16,16 C16,16.5522848 16.4477152,17 17,17 L17,17 Z" id="eye"/></g></g></svg></a>';
			}else{
				return '';
			}
		}

		function ajax_check_name()
		{	
			$model  = $this -> model;
			$name = FSInput::get('name');
			$data_id = FSInput::get('data_id',0,'int');
			$result = $model->get_result('title="'.$name.'" AND id != ' .  $data_id);
			if($result){
				echo 1;
			}else{
				echo 0;
			}
			return;
		}
	
	}

	function view_status($controle,$id) {

		if(!$id){
			return 'Lưu nháp';
		}else{
			$array_status = $controle -> array_status;
			return $array_status[$id];
		}
	}

	
	function view_creator($controle,$id) {
		if(!$id){
			return '';
		}else{
			$model  = $controle -> model;
			$user = $model -> get_record('id = ' .$id, 'fs_users');
			if(!empty($user)){
				if(!empty($user->fname) AND !empty($user->lname)){
					return $user->fname.' '. $user->lname;
				}else{
					return $user->username;
				}
			}else{
				return '';
			}
			
		}
	}

	

	
	

	
?>