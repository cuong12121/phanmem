<?php
	$url = $_SERVER['REQUEST_URI'];
	$return = base64_encode($url);
	$max_level = 1;
?>
<?php 
function display_comment_item($item,$childdren,$level,$max_level = 2,$return){
	$sub = ($level >= $max_level) ? ($max_level % 2) : ($level % 2);
	$html = '<div class="comment-item comment-item-'.$item -> id.' '. ($item -> parent_id? "comment-child":""). ' comment_level_'.$level.' comment_sub_'.$sub.'"   >';
				
	$html .= '<span class="name">'.$item -> name.'</span> ';
	$html .= '<span class="date">(nhận xét lúc:'. date('d/m/Y H:i',strtotime($item -> created_time)).')</span> ';
	$html .= '<div class="comment_content "> ';
	$html .=  $item -> comment;
//	$html .= '	<a class="button_reply" href="javascript: void(0)" >Trả lời</a>';
//	$html .= '	<div class="reply_area hide">';
//	$html .= '	<form action="#" method="post" name="comment_reply_form_'.$item -> id.'"  id="comment_reply_form_'.$item -> id.'"  class="form_comment">';
//	$html .= '<p class="name_email">';
//	$html .= '		<input type="text" id="name_'.$item -> id.'" value="Họ tên" name="name"   onfocus="if(this.value==\'Họ tên\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'Họ tên\'"/>';
//	$html .= '		<input type="text" id="email_'.$item -> id.'" value="Email" name="email"  onfocus="if(this.value==\'Email\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'Email\'" />';
//	$html .= '	</p>';
//	$html .= '		<div class="text_area_ct">';
//	$html .= '			<textarea id="text_'.$item -> id.'" cols="64" rows="4" name="text" onfocus="if(this.value==\'Nội dung\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'Nội dung\'">Nội dung</textarea>';
//	$html .= '		</div>';
//			 
//	$html .= '		<div class="reply_button_area ">';
//	$html .= '			<a class="button_reply_close button" href="javascript: void(0)" >';
//	$html .= '				<span>Đóng lại</span>';
//	$html .= '			</a>';
//	$html .= '			<a class="button" href="javascript: void(0);" onclick="javascript: submit_reply('.$item -> id.'); ">';
//	$html .= '				<span>Gửi</span>';
//	$html .= '			</a>';
//	$html .= '			<div class="clear"></div>';
//	$html .= '		</div>';
	
//	$html .= '<input type="hidden" value="1" name="raw" />';
//	$html .= '<input type="hidden" value="products" name="module" />';
//	$html .= '<input type="hidden" value="product" name="view" />';
//	$html .= '	<input type="hidden" value="save_reply" name="task" />';
//	$html .= '	<input type="hidden" value="'.$item->id.'" name="parent_id"  />';
//	$html .= '	<input type="hidden" value="'.$item->record_id.'" name="record_id"  />';
//	$html .= '	<input type="hidden" value="'.$return.'" name="return"  />';
//	$html .= '	</form>';
//	$html .= '	</div>';
	$html .= '</div>';
	if($level >= $max_level){
		$html .= '</div>';
	}
	if(isset($childdren[$item -> id]) && count($childdren[$item -> id])){
		foreach($childdren[$item -> id] as $c ){
			$html .= display_comment_item($c,$childdren,$level + 1,$max_level = 2,$return );
		}
	}
	if($level < $max_level){
		$html .= '</div>';
	}
	return $html;
}
?>
<div class='comments'>
				
	<!-- FORM COMMENT	-->
	<form action="#" method="post" name="comment_add_form" id='comment_add_form' class='form_comment' onsubmit="javascript: return submit_comment()">
		
		<!-- RATING	-->
		<label class='label_form'>Đánh giá sản phẩm này</label>
		<div class="rating_area cls">
			<div id="ratings" class="cls">
				<?php $point = $data -> rating_count ? round($data -> rating_sum /$data -> rating_count): 0 ; ?>
				<?php for($i = 0; $i < 5;$i ++){?>
					<input type="radio" name="rate" value="<?php echo ($i + 1)?>" title="<?php echo $i; ?>" id="rate<?php echo $i; ?>" <?php echo ($i+1) == $point?'checked="checked"':''?> /> 
				<?php }?>
				<?php
				// check cookies
				$disable_rating = 0;
				$str_cookies_rating = isset($_COOKIE['rating_product'])?$_COOKIE['rating_product']:'';
				if($str_cookies_rating){
					$arr_cookies_rating = explode(',',$str_cookies_rating);
					if(in_array($member -> id,$arr_cookies_rating))
						$disable_rating = 1;
				}
				?>
				<input type="hidden" name='rating_disable' id='rating_disable' value='<?php echo $disable_rating;?>'>	
				<input type="hidden" name='rating_value' id='rating_value' value=''>	
				<!-- end RATING	-->
			</div>
			<span class='rating_note'>Nhấn vào đây để đánh giá</span>
		</div>
		
		<div class="clear"></div>
		<label class='label_form'>Bình luận</label>
		<div class='content-area'>
			<textarea id="text" rows="3" name="text" placeholder="Nội dung" ></textarea>
		</div>
		<div class='name_email cls'>
			<div class='name_area'><input type="text" id="name" placeholder="Họ tên" name="name"   /></div>
			<div class='email_area'><input type="text" id="email" placeholder="Email" name="email"   /></div>
		</div>
		 <p class='captcha'>
			<input type="text" id="txtCaptcha" placeholder="Mã kiểm tra" name="txtCaptcha"  />
			<a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" >
				<img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" /> <span>Bấm vào đây để thay đổi mã hiển thị</span>
			</a>
			<div class="clear"></div>
		</p>
		
		
		<p class='button_area'>
			<button type="reset"  class='reset_bt'>Làm lại</button>
			<button type="submit" class='submit_bt'>Gửi bình luận</button>
			
			<div class='clear'></div>
		</p>
		<input type="hidden" value="1" name='raw' />
		<input type="hidden" value="products" name='module' />
		<input type="hidden" value="product" name='view' />
		<input type="hidden" value="save_comment" name='task' />
		<input type="hidden" value="<?php echo $data->id; ?>" name='record_id' id='record_id'  />
		<input type="hidden" value="<?php echo $return;?>" name='return'  />
	</form>
	<!-- end FORM COMMENT	-->
	
</div>
<?php 
		$num_child = array();
		$wrap_close = 0;
		if(isset($comments) && $comments){
		?>
			<div class="add-task">
					<div class='label_form' >Ý kiến quý khách</div>
					 <div class='clear'> </div>
			</div>
			<div class='comments_contents'>
			<?php foreach ($list_parent as $item){ ?>
				<?php echo  display_comment_item($item,$list_children,0,3,$return);?>
			<?php }?>
			</div>
		<?php }?>

