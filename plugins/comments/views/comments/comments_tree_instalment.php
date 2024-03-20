<?php 
	$return =FSInput::get ( 'cmt_return' );
	$module = FSInput::get ( 'module' );
	$view = FSInput::get ( 'view' );
	
	$max_level = 1;

?>
<?php 
function display_comment_item($item,$childdren,$level,$max_level = 1,$return,$module,$view, $ban_words = array()){
	$sub = ($level >= $max_level) ? ($max_level % 2) : ($level % 2);
	
	$str_image = str_ireplace(   array ( 'script ' ),  array (  'script'  ),  $item -> avatar   ); 

	if(strpos($str_image, 'script') !== false ){
		$user_avatar = '';
	}else{
		$user_avatar = URL_ROOT.str_replace('/original/', '/resized/', @$item->avatar);
	}

	$noavata = URL_ROOT.'images/noavata.jpg';
	$html = '<div class="_item '.$item -> id.' _level_'.$level.' _sub_'.$sub.'"   >';
	$x = $item -> comment;
	$name = $item -> name;
	$name = str_replace($ban_words, '***', $name);
//	$name = cutString($name, 45, '...');


	if($module == "products" || $module == "repairs"){



		$html .= '<article>';
		$html .= '<p class="clearfix cls" >';
//			$html .= '<span class="_img"><img  alt="" height="25" src="'. $user_avatar.'" onerror="javascript:this.src=\''.$noavata.'\'" /></span>';
			$html .= '<span class="_avatar">'.get_short_name($name).'</span>';
			$html .= '<span class="_name"  >'.$name.'</span>';
			if(@$user_level->level == 1 || $item ->is_admin==1){
				$html .= '<span class="_level">Quản trị viên</span>';
			}else{
				$x = preg_replace('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/i','***',$x); // extract email
				$x = preg_replace('/(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?/','***',$x); // extract phonenumber
				$x = str_replace($ban_words, '***', $x);
			}
		$html .= '</p>';			
		$html .= '<div class="_wrap">';

			$html .= '<p class="_content " itemprop="description"> '.$x.'</p>';
		
			$html .= '<div class="_control '.($level>=0?'hide':'').'">';
				$html .= '<a class="button_reply" href="javascript: void(0)" >Trả lời</a>';
//				$html .= '<span class="dot">.</span>';
//				$html .= '<a class="favorite" href="javascript: void(0)" >Thích</a>';
				$html .= '<span class="dot">.</span>';
				// $html .= '<span class="date">'.time_elapsed_string(strtotime($item -> created_time)).'</span>';
				$html .= '<time content="'.date('Y-m-d H:i',strtotime($item -> created_time)).'"  datetime="'.date('Y-m-d H:i',strtotime($item -> created_time)).'" title="'.date('Y-m-d H:i',strtotime($item -> created_time)).'">'.time_elapsed_string(strtotime($item -> created_time)).'</time>';
	}else{
		$html .= '<article >';
		$html .= '<p class="clearfix cls">';
//			$html .= '<span class="_img"><img  alt="" height="25" src="'. $user_avatar.'" onerror="javascript:this.src=\''.$noavata.'\'" /></span>';
			$html .= '<span class="_avatar">'.get_short_name($name).'</span>';
			$html .= '<span class="_name" >'.$name.'</span>';
			if(@$user_level->level == 1 || $item ->is_admin==1){
				$html .= '<span class="_level">Quản trị viên</span>';
			}else{
				$x = preg_replace('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/i','***',$x); // extract email
				$x = preg_replace('/(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?/','***',$x); // extract phonenumber
				$x = str_replace($ban_words, '***', $x);
			}
		$html .= '</p>';			
		$html .= '<div class="_wrap">';

			$html .= '<p class="_content " > '.$x.'</p>';
		
			$html .= '<div class="_control '.($level>=$max_level?'hide':'').'">';
				$html .= '<a class="button_reply" href="javascript: void(0)" >Trả lời</a>';
//				$html .= '<span class="dot">.</span>';
//				$html .= '<a class="favorite" href="javascript: void(0)" >Thích</a>';
				$html .= '<span class="dot">.</span>';
				// $html .= '<span class="date">'.time_elapsed_string(strtotime($item -> created_time)).'</span>';
				$html .= '<time>'.time_elapsed_string(strtotime($item -> created_time)).'</time>';
	}




			$html .= '</div>';
			$html .= '<div class="reply_area hide">';
				$html .= '<form action="javascript:void(0);" method="post" name="comment_reply_form_'.$item -> id.'"  id="comment_reply_form_'.$item -> id.'"  class="form_comment cls" onsubmit="javascript: submit_reply('.$item -> id.');return false;">';
		
					$html .= '<div class="_textarea">';
						$html .= '<textarea texid = "txt_content_'.$item -> id.'" id="cmt_content_'.$item -> id.'" class="cmt_content"  name="content" placeholder="Viết bình luận của bạn..."></textarea>';
					$html .= '</div>';
					$html .='<input type="button" class="btn-comment-mb-rep" value="Gửi bình luận">';
					
					$html .= '<div class="full-screen-mobile"></div>'; 
					 
					$html .= '<div class="wrap_r cls">   ';    
					if(empty($_COOKIE['user_id'])){
						$html .= '<div class="title-mb">';
						$html .= 'Thông tin người gửi';
						$html .= '<span class="close-md-comment"><svg height="16px" viewBox="0 0 64 64" enable-background="new 0 0 64 64">
  <g>
    <path fill="black" d="M28.941,31.786L0.613,60.114c-0.787,0.787-0.787,2.062,0,2.849c0.393,0.394,0.909,0.59,1.424,0.59   c0.516,0,1.031-0.196,1.424-0.59l28.541-28.541l28.541,28.541c0.394,0.394,0.909,0.59,1.424,0.59c0.515,0,1.031-0.196,1.424-0.59   c0.787-0.787,0.787-2.062,0-2.849L35.064,31.786L63.41,3.438c0.787-0.787,0.787-2.062,0-2.849c-0.787-0.786-2.062-0.786-2.848,0   L32.003,29.15L3.441,0.59c-0.787-0.786-2.061-0.786-2.848,0c-0.787,0.787-0.787,2.062,0,2.849L28.941,31.786z"/>
  </g>
</svg></span>';
						$html .= '</div>';


						$html .= '<div class="wrap_loginpost mbl"> ';           
//							$html .= '<aside class="_left"> ';               
//								$html .= '<label>Đăng nhập bằng tài khoản Didongthongminh để bình luận của bạn được duyệt &amp; trả lời nhanh hơn</label>   ';             
//								$html .= '<a href="javascript:void(0)"><i class="_facebook"></i></a> ';               
//								$html .= '<a href="javascript:void(0)"><i class="_googleplus"></i></a>  ';              
//								$html .= '<a href="javascript:void(0)" class="dropsub"><i class="_mobileworld"></i></a> ';               
//								$html .= '<div class="_noaccount">Bạn chưa có tài khoản Didongthongminh.vn? ';
//									$html .= '<a target="_blank" href="">Đăng ký ngay</a>';
//								$html .= '</div> ';            
//							$html .= '</aside>';

							$html .= '<aside class="_right"> ';               
								$html .= '<input required class="txt_input" name="name"  id="cmt_name_'.$item -> id.'" type="text" placeholder="Họ tên (bắt buộc)" maxlength="50" autocomplete="off" value="'.@$_COOKIE['full_name'].'">';
								$html .= '<input required class="txt_input" name="email" id="cmt_email_'.$item -> id.'" type="email" placeholder="Email (bắt buộc)"  value="'. @$_COOKIE['user_email'].'" >';                
								// $html .= '<div class="pull-right">';   
								// 	$html .= '<a class="_close_comment button" href="javascript: void(0)" >Đóng lại</a>';
								// 	$html .= '<input type="submit" class="_btn_comment" value="Gửi bình luận">';  
								// $html .= '</div>';
							$html .= '</aside>';
						$html .= '</div>';
					}
					$html .= '<div class="wrap_submit mbl">';
//						if(isset($_COOKIE['user_id'])){
//
//							if(isset($_COOKIE['avatar'])){
//								if(strpos($_COOKIE['avatar'], 'http:') !== false || strpos($_COOKIE['avatar'], 'https:') !== false){
//									$avatar = $_COOKIE['avatar'];
//								}else{
//									$avatar = URL_ROOT.$_COOKIE['avatar'];
//								}
//							}
//							$noavata = URL_ROOT.'images/noavata.jpg';
//							$html .= '<div class="userinfo in" id="userinfoLog">';
//								$html .= '<img class="avaS" src="'.$avatar.'"  onerror="javascript:this.src=\''.$noavata.'\'">';
//								$html .= '<span class="uname">'.$_COOKIE["full_name"].'</span>';
//								$html .= '<a  href="javascript:void(0)">(Thoát)</a>';
//							$html .= '</div> ';
//
//							$html .= '<input name="name" type="hidden"  id="cmt_name_'.$item -> id.'"  value="'.$_COOKIE['full_name'].'">';
//							$html .= '<input name="email" type="hidden"  id="cmt_email_'.$item -> id.'"  value="'.$_COOKIE['user_email'].'">';
//						}
						// $html .= '<a class="_close_comment button" href="javascript: void(0)" >Đóng lại</a>';
						$html .= '<input type="submit" class="_btn_comment" value="Gửi bình luận">';   
					$html .= '</div>';
					$html .= '</div><!-- .wrap_r -->';
					
					
					$html .= '<input type="hidden" value="'.$module.'" name="module"   id="_cmt_module_'.$item->id.'" />';
					$html .= '<input type="hidden" value="'.$view.'" name="view" id="_cmt_view_'.$item->id.'" />';
					$html .= '<input type="hidden" value="'.$module.'" name="type" id="_cmt_type_'.$item->id.'" />';				
					$html .= '<input type="hidden" value="save_reply" name="task" />';
					$html .= '<input type="hidden" value="'.$item->id.'" name="parent_id"  id="parent_id_'.$item->id.'"/>';
					$html .= '<input type="hidden" value="'.$item->record_id.'" name="record_id" id="_cmt_record_id_'.$item->id.'" />';
					$html .= '<input type="hidden" value="'.$return.'" name="return"  id="_cmt_return_'.$item->id.'" />';
					$html .= '<input type="hidden" value="/index.php?module=comments&view=comments&type='.$module.'&task=save_reply&raw=1" name="return" id="link_reply_form_'.$item -> id.'" />';
				$html .= '</form>';
			$html .= '</div>';
		$html .= '</div>';
		$html .= '</article>';
	if($level >= $max_level){
		$html .= '</div>';
	}
	if(isset($childdren[$item -> id]) && count($childdren[$item -> id])){
		foreach($childdren[$item -> id] as $c ){
			// echo $c;
			$html .= display_comment_item($c,$childdren,$level + 1,$max_level = 1,$return,$module,$view  );
		}
	}
	if($level < $max_level){
		$html .= '</div>';
	}
	return $html;
}
?>

<?php
global $config;
$ban_words = explode(',', $config['ban_words_list']);
$num_child = array();
$wrap_close = 0;
if($comments){

?>
	<div class='_contents'>
	<?php foreach ($list_parent as $item){ ?>
		<?php echo  display_comment_item($item,$list_children,0,3,$return,$module,$view, $ban_words);?>
	<?php }?>
	</div>
	<?php if($pagination) echo $pagination->showPagination(3); ?>
<?php }?>

<?php 
function get_short_name($string){
	$arr_buff = explode(' ',$string);
	if(!$arr_buff)
		return;
	$k = 0;
	$short = '';
	for($i = count($arr_buff);$i > 0; $i --){
		if($arr_buff[$i - 1]){
			$short = mb_substr($arr_buff[$i - 1], 0, 1,"UTF-8").$short;
			$k ++;
			if($k > 1)
				break;
		}
		
	}
	return $short?mb_strtoupper($short):'';
}
?>

