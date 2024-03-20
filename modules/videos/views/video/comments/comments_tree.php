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
	$html .= '	<a class="button_reply" href="javascript: void(0)" >Trả lời</a>';
	$html .= '	<div class="reply_area hide">';
	$html .= '	<form action="#" method="post" name="comment_reply_form_'.$item -> id.'"  id="comment_reply_form_'.$item -> id.'"  class="form_comment">';
	$html .= '<p class="name_email">';
	$html .= '		<input type="text" id="name_'.$item -> id.'" value="Họ tên" name="name" size="40"  onfocus="if(this.value==\'Họ tên\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'Họ tên\'"/>';
	$html .= '		<input type="text" id="email_'.$item -> id.'" value="Email" name="email" size="40" onfocus="if(this.value==\'Email\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'Email\'" />';
	$html .= '	</p>';
	$html .= '		<div class="text_area_ct">';
	$html .= '			<textarea id="text_'.$item -> id.'" cols="64" rows="4" name="text" onfocus="if(this.value==\'Nội dung\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'Nội dung\'">Nội dung</textarea>';
	$html .= '		</div>';
			 
	$html .= '		<div class="reply_button_area ">';
	$html .= '			<a class="button_reply_close button" href="javascript: void(0)" >';
	$html .= '				<span>Đóng lại</span>';
	$html .= '			</a>';
	$html .= '			<a class="button" href="javascript: void(0);" onclick="javascript: submit_reply('.$item -> id.'); ">';
	$html .= '				<span>Gửi</span>';
	$html .= '			</a>';
	$html .= '			<div class="clear"></div>';
	$html .= '		</div>';
	
	$html .= '<input type="hidden" value="1" name="raw" />';
	$html .= '<input type="hidden" value="news" name="module" />';
	$html .= '<input type="hidden" value="news" name="view" />';
	$html .= '	<input type="hidden" value="save_reply" name="task" />';
	$html .= '	<input type="hidden" value="'.$item->id.'" name="parent_id"  />';
	$html .= '	<input type="hidden" value="'.$item->news_id.'" name="record_id"  />';
	$html .= '	<input type="hidden" value="'.$return.'" name="return"  />';
	$html .= '	</form>';
	$html .= '	</div>';
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
				
		<?php 
		$num_child = array();
		$wrap_close = 0;
		if($comments){
		?>
			<div class="add-task">
					<div class='comment_form_title_send' >Ý kiến bạn đọc</div>
					 <div class='clear'> </div>
			</div>
			<div class='comments_contents'>
			<?php foreach ($list_parent as $item){ ?>
				<?php echo  display_comment_item($item,$list_children,0,3,$return);?>
			<?php }?>
			</div>
		<?php }?>
	
	
	<!-- FORM COMMENT	-->
	<div class='comment_form_title' >Gửi bình luận</div>
	<form action="#" method="post" name="comment_add_form" id='comment_add_form' class='form_comment'>
	<!--	<p class='name_email'>
			<input type="text" id="name" value="Họ tên" name="name" size="40"  onfocus="if(this.value=='Họ tên') this.value=''" onblur="if(this.value=='') this.value='Họ tên'"/>
			<input type="text" id="email" value="Email" name="email" size="40" onfocus="if(this.value=='Email') this.value=''" onblur="if(this.value=='') this.value='Email'" />
		</p>-->
		<textarea id="text" cols="84" rows="5" name="text" onfocus="if(this.value=='Nội dung') this.value=''" onblur="if(this.value=='') this.value='Nội dung'">Nội dung</textarea>
	<!--	 <p class='captcha'>
			<input type="text" id="txtCaptcha" value="Mã kiểm tra" name="txtCaptcha"  maxlength="10" size="23" onfocus="if(this.value=='Mã kiểm tra') this.value=''" onblur="if(this.value=='') this.value='Mã kiểm tra'" />
			<a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" >
				<img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" /> <span>Bấm vào đây để thay đổi mã hiển thị</span>
			</a>
		</p>-->
		<p class='button_area'>
			<a class="button" href="javascript: void(0)" id='submitbt'>
				<span>Gửi</span>
			</a>
	<!--		<a class="button" href="javascript: void(0)" id='resetbt'>
				<span>Làm lại</span>
			</a>-->
			<div class='clear'></div>
		</p>
		<input type="hidden" value="1" name='raw' />
		<input type="hidden" value="news" name='module' />
		<input type="hidden" value="news" name='view' />
		<input type="hidden" value="save_comment" name='task' />
		<input type="hidden" value="<?php echo $data->id; ?>" name='record_id' id='record_id'  />
		<input type="hidden" value="<?php echo $return;?>" name='return'  />
	</form>
	<!-- end FORM COMMENT	-->
</div>

