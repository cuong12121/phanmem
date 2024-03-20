<?php
	class AqControllersAq extends Controllers
	{
		function __construct()
		{
			$this->view = 'aq' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$categories = $model->get_categories_tree();
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$categories = $model->get_categories_tree();

			// $products_categories 
			
			// data from fs_news_categories
			$categories_home  = $model->get_categories_tree();
			$maxOrdering = $model->getMaxOrdering();
			
			// products related
			$products_categories = $model->get_products_categories_tree();
				
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			$categories  = $model->get_categories_tree();
//			$tags_categories = $model->get_tags_categories();
			// products related
			$products_categories = $model->get_products_categories_tree();
			$products_related = $model -> get_products_related($data -> products_related);
			
			// data from fs_news_categories
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
		function view_comment($advice_id){
			$link = 'index.php?module=aq&view=comments&keysearch=&text_count=1&text0='.$advice_id.'&filter_count=1&filter0=0';
			return '<a href="'.$link.'" target="_blink">Comment</a>'; 
		}
		/***********
		 * PRODUCTS RELATED
		 ************/
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
						$html .= $item -> title;				
						$html .= '</div>';					
					}else{
						$html .= '<div class="products_related_item  products_related_item_'.$item -> id.'" onclick="javascript: set_products_related('.$item->id.')">';	
						$html .= $item -> title;				
						$html .= '</div>';	
					}
				}
				$html .= '</div>';
				return $html;
		}

		
		/***********
		 * end PRODUCTS RELATED.
		 ************/


		function send_email(){
			$return= FSInput::get('return');
			$link = base64_decode($return);
			$id= FSInput::get('id');
			if(!$id){
				setRedirect($link,'Có lỗi xảy ra !');
				return false;
			}

			$model = $this -> model;
			$data = $model->get_record('id = '. $id, 'fs_aq');
			$link_aq = FSRoute::_('index.php?module=aq&view=aq&id='.$data->id.'&code='.$data -> alias.'&Itemid=91');
			$mailer = FSFactory::getClass('Email','mail');
			$select = 'SELECT * FROM fs_config WHERE published = 1';
			global $db;
			$db -> query($select);
			$config = $db->getObjectListByKey('name');
			// $admin_name  = $config['admin_name']-> value;
			// $admin_email  = $config['admin_email']-> value;
			$site_name  = $config['site_name']-> value;
			
			$mailer -> isHTML(true);
			$mailer -> setSender(array('buixuanthangcntt1@gmail.com','Quản trị viên'));
			$mailer -> AddAddress($data->email,$data->asker);
			$mailer -> setSubject($site_name.' - Admin đã trả lời câu hỏi của bạn');
			// body
			$body = '';
			$body .= '<div>Chào '.$data->asker.'!</div>';
			$body .= '<div>Câu hỏi: "'.$data->question.'" đã có câu trả lời. </div>';
			$body .= '<div>Vào link sau để xem chi tiết <a href="'.$link_aq.'">'.$link_aq.'</a></div>';
			$body .= '<div>Xin cảm ơn!</div>';
			// printr($body);			
			$mailer -> setBody($body);
			if(!$mailer ->Send())
				return false;
			// return true;

			setRedirect($link,'Gửi thành công');
		}

	}

	function view_send_mail_bt($controle,$id) {
		$return =  base64_encode($_SERVER['REQUEST_URI']);
		$link = 'index.php?module=aq&view=aq&task=send_email&id='.$id.'&return='.$return;
		
			// $url = base64_decode($_)
		return '<a href="'.$link.'" style="
			    background: #007cff;
			    display: inline-block;
			    padding: 5px 13px;
			    border-radius: 5px;
			    color: #FFF;
			    font-weight: bold;
			    margin-right: 10px;
			    margin-top: 10px;
			">Gửi</a>';
		
		
	}



?>