<?php
/*
 * Huy write
 */
	// controller
	
	class AqControllersAq  extends FSControllers
	{
		var $module;
		var $view;
	
		function display()
		{
			// call models
			$model = $this -> model;
			
			$data = $model->getAq();
			
			if(!$data)
				die('Kh&#244;ng t&#7891;n t&#7841;i b&#224;i vi&#7871;t n&#224;y');
			$ccode = FSInput::get('ccode');
				
			$category_id = $data -> category_id;
			
			$category = $model -> get_category_by_id($category_id);
			if(!$category)
				die('Kh&#244;ng t&#236;m th&#7845;y Category');
			$Itemid = 7;
//			if($ccode){
//				if(trim($ccode) != trim($category-> alias )){
//					$link_advice = FSRoute::_("index.php?module=aq&view=advice&code=".trim($data->alias)."&ccode=".trim($category-> alias)."&Itemid=$Itemid");
//					setRedirect($link_advice);
//				}
//			}
			
			// relate
			$relate_aq_list = $model->getRelateAqList($category_id);
			$total_content_relate  = count($relate_aq_list);
			$str_ids = '';
			for($i = 0; $i < $total_content_relate; $i ++){
				$item = $relate_aq_list[$i];
				if($i > 0) $str_ids .= ',';
				$str_ids .= $item -> category_id;
			}
			$content_category_alias = $model->get_content_category_ids($str_ids);
			$comments  = $model -> get_comments($data -> id);
			// total comment
			$total_comment = count($comments);
			if($total_comment){
					$list_parent = array();
					$list_children = array();
					foreach($comments as $item){
						if(!$item -> parent_id){
							$list_parent[] = $item;
						}else{
							if(!isset($list_children[$item->parent_id]))
								$list_children[$item->parent_id] = array();
							$list_children[$item->parent_id][] = $item;	
						}
					}
				}
			
			// old relate and newest relate
//			$newer_advice_list = $model->getNewerAqList($category->id,$data->created_time);
//			$older_advice_list = $model->getOlderAqList($category->id,$data->created_time);

			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>FSText::_('Hỏi đáp'), 1 => FSRoute::_('index.php?module=aq&view=home&Itemid=2'));	
			//$breadcrumbs[] = array(0=>$category -> name, 1 => FSRoute::_('index.php?module=aq&view=cat&id='.$data -> category_id.'&ccode='.$data -> category_alias.''));	
			$breadcrumbs[] = array(0=>$data->title, 1 => FSRoute::_("index.php?module=aq&view=aq&id=".$data->id."&code=".$data->alias));
			
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
			// seo
			$tmpl -> set_data_seo($data);
			
			// call views			
		include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
	function send_question() {
		// $fssecurity = FSFactory::getClass ( 'fssecurity' );
		// $fssecurity->checkLogin ();
		// call models
		$model = $this->model;
		$Itemid = 7;
		$breadcrumbs = array ();
		$breadcrumbs [] = array (0 => 'Gửi câu hỏi', 1 => '' );
		
		global $tmpl, $module_config;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$tmpl->assign ( 'title', 'Gửi yêu cầu' );
		//$cf_send_request_note = $model -> get_config('send_request_note'); 
		
		$categories = $model -> get_categories();
		
		// seo
		//		$tmpl->set_data_seo ( $data );

		// call views			
		include 'modules/' . $this->module . '/views/' . $this->view . '/form_question.php';
	}
		
		/* Save comment */
		function save_comment(){
			$return = FSInput::get('return');
			$url = base64_decode($return);
			
			if(!$this -> check_captcha()){
				$msg = 'Mã hiển thị không đúng';
				setRedirect($url,$msg,'error');
			}
			$model = $this -> model;
			if(!$model -> save_comment()){
				$msg =  'Chưa lưu thành công comment!';
				setRedirect($url,$msg,'error');
			} else {
				setRedirect($url,'Cảm ơn bạn đã gửi comment');
			}
		}
	/* 
		 * save
		 */
	function save() {
		$model = $this->model;
		$id = $model->save ();
		if ($id) {
			$link = FSRoute::_ ( "index.php?module=aq&view=aq&task=send_question&Itemid=14" );
			$msg = "Nội dung đã được gửi. Xin cảm ơn bạn !";
			//				if(!$this -> send_mail()){
			//					$msg = FSText::_("Nội dung đã được gửi. Xin cảm ơn vì đã liên hệ với chúng tôi !");
			//				}
			setRedirect ( $link, $msg );
			return;
		} else {
			$link = FSRoute::_ ( "index.php?module=aq&view=aq&task=send_question&Itemid=14" );
			$msg = "Xin lỗi! Yêu cầu của bạn không gửi được";
			setRedirect ( $link, $msg );
			return;
		}
	}
		/* Save comment reply*/
		function save_reply(){
			$return = FSInput::get('return');
			$url = base64_decode($return);
			
			$model = $this -> model;
			if(!$model -> save_comment()){
				$msg =  'Chưa lưu thành công comment!';
				setRedirect($url,$msg,'error');
			} else {
				setRedirect($url,'Cảm ơn bạn đã gửi comment');
			}
		}
		
		// check captcha
		function check_captcha(){
			$captcha = FSInput::get('txtCaptcha');
			
			if ( $captcha == $_SESSION["security_code"]){
				return true;
			} else {
			}
			return false;
		}
		
		function rating(){
			$model = $this -> model;
			if(!$model -> save_rating()){
				echo '0';
				return;
			} else {
				echo '1';
				return;
			}
		}
	function count_views(){
			$model = $this -> model;
			if(!$model -> count_views()){
				echo 'hello';
				return;
			} else {
				echo '1';
				return;
			}
		}
	}
	
?>