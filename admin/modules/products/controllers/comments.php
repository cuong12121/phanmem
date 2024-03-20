<?php
	class ProductsControllersComments extends Controllers{
	
		function __construct()
		{
			$this->view = 'comments' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();

			//print_r($list);
			$categories = $model->get_categories_tree_all();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			return;
		}
		
		/*
		 * Group user > 3 => Have permission
		 */
		function check_comments(){
			$user_group = $_SESSION['cms_group'];
			$link = 'index.php';
			if($user_group < 3){
				setRedirect($link,FSText :: _('Không có quyền truy cập vào link này'),'error');
				return false;
			}
				
			return true;
		}
		
		
		function ajax_get_comments_by_product()
		{
			$record_id = FSInput::get('record_id',0,'int');
			if(!$record_id){
				echo 'record_id = null';
				return;
			}
			$model = $this -> model;
			$data = $model->get_comments_by_product($record_id);
			$html = $this -> genarate_comments($data);
			echo $html;
			if(count($data)){
				$model->update_unread_for_comments($record_id);	
			}
			return;
		}
		
		function genarate_comments($data){
			// echo "<pre>";
			// print_r($data);
			// die;
			$html = '';
			$html .= '<div class="comments">';
			foreach ($data as $item){
				$html .= '<div class="comment-item comment-item-'.$item -> id.' '.($item -> parent_id? "comment-child":"") .'">';	
					$html .= '<div class="comment_info">';
						$html .= '<div class="comment_head"><span class="name" >'. $item -> name.'</span> ';	
						$html .= '<span class="email" >('. $item -> email.')</span></div>';	
						$html .= '<div><span class="comment" id="comment_content_'.$item->id.'"  onclick="javascript: open_form_edit('.$item -> id.')">'. $item -> comment.'</span></div>';	
						$html .= '<div><strong>Đánh giá: </strong>'. $item -> comment.'</span></div>';
						for($i = 0; $i < 5;$i ++){
							if($i < $item->rate ){
								$html .= '<span><svg height="24px" version="1.1" width="24px" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><g transform="translate(0 -1028.4)"><path d="m9.5999 1.4564 1.5501 4.7699 5.015 0.0002-4.057 2.9482 1.55 4.7703-4.0581-2.948-4.0577 2.948 1.5497-4.7703-4.0575-2.9482 5.0154-0.0002z" fill="#f1c40f" stroke="#f39c12" stroke-width=".69755" transform="matrix(1.4336 0 0 1.4336 -1.7602 1028.9)"/></g></svg>
								</span>
								';
							}else{
								$html .= '<span><svg height="24px" version="1.1" viewBox="0 0 32 32" width="24px" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"><title/><desc/><defs/><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="#929292" id="icon-23-star"><path d="M16,23 L7,29 L11,19 L2,13 L12,13 L16,3 L20,13 L30,13 L21,19 L25,29 L16,23 L16,23 Z M16,21.7530518 L9.20001221,26.2999878 L12.4000244,18.6000061 L5.20001221,14 L12.6999512,14 L16,5.5 L19.3000488,14 L26.8000488,14 L19.5999756,18.6000061 L22.8000488,26.2999878 L16,21.7530518 L16,21.7530518 Z" id="star"/></g></g></svg></span>';
							}
						}
						//edit
						$html .= '<div class="edit_area hide" id="edit_area_'.$item->id.'">	';	
						$html .= '<div class="text_area_ct">';		
						$html .= '<textarea id="text_edit_'.$item -> id.'" cols="142" rows="4" name="text" >'.$item -> comment.'</textarea>';
						$html .= '</div>';
						$html .= '	<div class="reply_button_area">	';
						$html .= '		<a class="button" href="javascript: void(0);" onclick="javascript: submit_edit('.$item -> id.','.$item -> record_id.')"';
						$html .= '			<span>Gửi</span>	';
						$html .= '		</a>&nbsp;&nbsp;	';
						$html .= '		<a class="button_edit_close" href="javascript: void(0)" onclick="javascript: close_form_edit('.$item -> id.')" >';
						$html .= '			<span>Đóng lại</span>	';
						$html .= '		</a>&nbsp;&nbsp;	';
						$html .= '		<div class="clear"></div>	';
						$html .= '	</div>	';
						$html .= '</div>';
						//end edit
						
						$html .= '<div class="actions"><span class="datetime" >'. date('d/m/Y H:i',strtotime($item -> created_time)).'</span>';	
					//	$html .= '<span id="errmsg_'.$item -> id.'" class="errmsg" style="display: none;"></span>';
					//	$html .= 'Chấm điểm: <input class="button txt_mark"  value="'.$item -> add_point.'" id="txt_point_'.$item -> id.'"  onchange="javascript: save_point('.$item -> id.');"  size="2"/>&nbsp;&nbsp;';
						$html .= '<a class="button bt_reply" id="bt_reply_'.$item -> id.'" href="javascript: void(0);" onclick="javascript: call_form_reply('.$item -> id.'); ">Trả lời</a>';
						$html .= '<span class="status">Trạng thái:';
						if($item -> published){
							$html .= '<a href="javascript:void(0);" onclick="return ajax_unpublished('.$item -> id.','.$item -> record_id .')" title="Click vào để ngừng xuất bản">';
							$html .= '<img border="0" src="templates/default/images/published.png" alt="Enabled status"></a>';
						}else{
							$html .= '<a href="javascript:void(0);" onclick="return ajax_published('.$item -> id.','.$item -> record_id .')" title="Click vào để xuất bản">';
							$html .= '<img border="0" src="templates/default/images/unpublished.png" alt="Disable status"></a>';
						}
						$html .= '</span><span class="remove_button">Xóa:';
						$html .= '&nbsp;&nbsp;<a href="javascript:void(0);" onclick="return ajax_del('.$item -> id.','.$item -> record_id.','.$item -> published .')" title="Xóa">';
						$html .= '<img border="0" src="templates/default/images/toolbar/remove_2.png" alt="Remove" ></a></span></div>';
					$html .= '</div>';
					$html .= '<div class="reply_area hide" id="reply_area_'.$item->id.'">	';	
					$html .= '<div class="text_area_ct">';		
					$html .= '<input type="text" id="name_'.$item -> id.'" onfocus="if(this.value==\'Họ tên\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'Họ tên\'" value="'.$_SESSION['ad_username'].'" size="63" /><br/>';
					$html .= '<textarea id="text_'.$item -> id.'" cols="72" rows="4" name="text" onfocus="if(this.value==\'Nội dung\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'Nội dung\'">Nội dung</textarea>';
					$html .= '</div>';
					$html .= '	<div class="reply_button_area">	';
					$html .= '		<a class="button" href="javascript: void(0);" onclick="javascript: submit_reply('.$item -> id.','.$item -> record_id.')"';
					$html .= '			<span>Gửi</span>	';
					$html .= '		</a>	';
					$html .= '		<a class="button_reply_close" href="javascript: void(0)" onclick="javascript: close_form_reply('.$item -> id.')" >';
					$html .= '			<span>Đóng lại</span>	';
					$html .= '		</a>	';
					$html .= '		<div class="clear"></div>	';
					$html .= '	</div>	';
					$html .= '</div>	';
				$html .= '</div>';				
			}
			$html .= '</div>';
			return $html;
		}
		
		function ajax_published(){
			$model = $this -> model;
			$rs = $model->ajax_published(1);
			return;
		}
		function ajax_unpublished(){
			$model = $this -> model;
			$rs = $model->ajax_published(0);
			return;
		}
		function ajax_del(){
			$model = $this -> model;
			$rs = $model->ajax_del();
			return;
		}
		
		function ajax_save_comment(){
			$model = $this -> model;
			$model -> save_comment();
			return;
		}
		function ajax_edit_comment(){
			$model = $this -> model;
			$model -> edit_comment();
			return;
		}
		
//		function edit()
//		{
//			$ids = FSInput::get('id',array(),'array');
//			$id = $ids[0];
//			$model = $this -> model;
////			$categories  = $model->get_categories_tree();
//			$categories = $model->get_categories_tree_all();
////			$tags_categories = $model->get_tags_categories();
//			$data = $model->get_product_by_id($id);
//			if(!$data){
//				echo "<br/>Không tồn tại hoặc không có quyền truy cập";
//				return;
//			}
//			$arr_status = $this ->  arr_status;
//			$group_id = $_SESSION['cms_group'];
//			$members = $model -> get_records('published = 1','fs_members');
//			// owner
//			$this -> create_status_for_user( $group_id,0,$data -> status);
//			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';	
//		}
		
		/*
		 * Tạo ra mảng status cho người dùng
		 */
		function create_status_for_user($group_id, $is_owner,$status_current){
//			$this -> arr_status = array(1=>'Lưu nháp',2=>'BTV từ chối',3=>'Chờ BTV duyệt',4=>'Đã biên tập',5=>'Hạ bài (kéo về)',6=>'Xuất bản');
			switch($group_id){
				case '1':
					if($status_current == 2){
						$this -> arr_status_edit = array(1=>'Lưu nháp',2=>'BTV từ chối',3=>'Chờ BTV duyệt');
						return;
					}else{
						$this -> arr_status_edit = array(1=>'Lưu nháp',3=>'Chờ BTV duyệt');
						return;
					}
				case '2':
					if($is_owner){
						if($status_current == 5){
							$this -> arr_status_edit = array(1=>'Lưu nháp',2=>'BTV từ chối',3=>'Chờ BTV duyệt',4=>'Đã biên tập',5=>'Hạ bài (kéo về)');
							return;
						}else{
							$this -> arr_status_edit = array(1=>'Lưu nháp',2=>'BTV từ chối',3=>'Chờ BTV duyệt',4=>'Đã biên tập');
							return;
						}
					}else{
						if($status_current == 5){
							$this -> arr_status_edit = array(2=>'BTV từ chối',3=>'Chờ BTV duyệt',4=>'Đã biên tập',5=>'Hạ bài (kéo về)');
							return;
						}else{
							$this -> arr_status_edit = array(2=>'BTV từ chối',3=>'Chờ BTV duyệt',4=>'Đã biên tập');
							return;
						}
					}
				case '3':
				case '4':
					if($is_owner){
						$this -> arr_status_edit = array(1=>'Lưu nháp',2=>'BTV từ chối',3=>'Chờ BTV duyệt',4=>'Đã biên tập',5=>'Hạ bài (kéo về)',6=>'Xuất bản');
						return;
					}else{
						$this -> arr_status_edit = array(2=>'BTV từ chối',3=>'Chờ BTV duyệt',4=>'Đã biên tập',5=>'Hạ bài (kéo về)',6=>'Xuất bản');
						return;
					}
			}
		}
		
		function view_comment($product){
			$link = 'index.php?module=products&view=comments&keysearch=&text_count=1&text0='.$news ->id.'&filter_count=1&filter0=0';
			$html = '';
			if($product -> comments_unread){
				$html .= '<strong>'.$product -> comments_unread.'/'.$product -> comments_total.'</strong>';
			}else{
				$html .= $product -> comments_unread.'/'.$product -> comments_total;
			}
			$html .=  '<br/><a href="'.$link.'" ><img border="0" src="templates/default/images/comment.png" alt="Comment"></a>';
			return $html; 
		}
		
		function view_status($status){
			$arr_status = $this -> arr_status;
			return $arr_status[$status]; 
		}
		function save_point(){
			$model  = $this -> model;
		
			// call Models to save
			$rs = $model->save_point();
			echo $rs;
			return ;
		}
	
	}
?>
