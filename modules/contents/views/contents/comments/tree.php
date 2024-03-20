<?php 
	$url = $_SERVER['REQUEST_URI'];
	$return = base64_encode($url);
	$max_level = 1;
?>
<?php 
function display_comment_item($item,$childdren,$level,$max_level = 2){
	$sub = ($level >= $max_level) ? ($max_level % 2) : ($level % 2);
	$html = '<div class="comment-item comment-item-'.$item -> id.' '. ($item -> parent_id? "comment-child":""). ' comment_level_'.$level.' comment_sub_'.$sub.'"   >';
				
	$html .= '<span class="name">'.$item -> name.'</span> ';
	$html .= '<span class="date">(nhận xét lúc:'. date('d/m/Y H:i',strtotime($item -> created_time)).')</span> ';
	$html .= '<div class="comment_content "> ';
	$html .=  $item -> comment;
	$html .= '	<a class="button_reply" href="javascript: void(0)" >Trả lời</a>';
	$html .= '	<div class="reply_area hide">';
	$html .= '		<div class="text_area_ct">';
	$html .= '			<textarea id="text_'.$item -> id.'" cols="64" rows="4" name="text" onfocus="if(this.value==\'Nội dung\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'Nội dung\'">Nội dung</textarea>';
	$html .= '		</div>';
			 
	$html .= '		<div class="reply_button_area">';
	$html .= '			<a class="button_reply_close" href="javascript: void(0)" >';
	$html .= '				<span>Đóng lại</span>';
	$html .= '			</a>';
	$html .= '			<a class="button" href="javascript: void(0);" onclick="javascript: pre_submit_reply('.$item -> id.'); ">';
	$html .= '				<span>Gửi</span>';
	$html .= '			</a>';
	$html .= '			<div class="clear"></div>';
	$html .= '		</div>';
	$html .= '	</div>';
	$html .= '</div>';
	if($level >= $max_level){
		$html .= '</div>';
	}
	if(isset($childdren[$item -> id]) && count($childdren[$item -> id])){
		foreach($childdren[$item -> id] as $c ){
			$html .= display_comment_item($c,$childdren,$level + 1 );
		}
	}
	if($level < $max_level){
		$html .= '</div>';
	}
	return $html;
}
?>
<div class='news_comments'>
				
		<?php 
		$num_child = array();
		$wrap_close = 0;
		if($total_comment){
		?>
			<div class="add-task">
					<div class='comment_form_title_send' >Ý kiến bạn đọc</div>
					 <div class='clear'> </div>
			</div>
			<div class='comments_contents'>
			<?php foreach ($list_parent as $item){ ?>
				<?php echo  display_comment_item($item,$list_children,0);?>
			<?php }?>
			</div>
		<?php }?>
	
	
	<!-- FORM COMMENT	-->
	<div class='comment_form_title' ><a href="javascript:void(0)" id='comment_title'><span>Gửi bình luận</span></a></div>
	<form action="<?php echo FSRoute::_('index.php?module=news&view=news&task=save')?>" method="post" name="news_comment_add_form" id='news_comment_add_form' class='form_comment' >
		<input type="hidden" id="comment_content" value="" name="comment_content" />
		<input type="hidden" value="0" name='parent_id' id='parent_id' />
		<!--	COLOR BOX	-->
		<a class='inline' href="#inline_content"></a>
		<div style='display:none'>
			<div id='inline_content' >
				<div class='title_popup'>
					<img alt="Logo Phutoday" src="/images/logos/logo-bottom.png" />
					<span>Xác thực thông tin của bạn để gửi bình luận</span> 
				</div>
				
				<div class='content_popup'>
					<table width="100%" cellpadding="6" >
						<tr>
							<td width="30%">Họ tên</td>
							<td><input type="text" id="name" value="" name="name" size="44" /></td>
						</tr>
						<tr>
							<td>Email</td>
							<td>
								<input type="text" id="email" value="" name="email" size="44"  />
							</td>
						</tr>
						<tr>
							<td>Mã hiển thị</td>
							<td>
								<input type="text" id="txtCaptcha" value="Mã kiểm tra" name="txtCaptcha"  maxlength="10" size="23" onfocus="if(this.value=='Mã kiểm tra') this.value=''" onblur="if(this.value=='') this.value='Mã kiểm tra'" />
								<a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" >
									<img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
								</a>
								<span id='not_captcha'></span>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="button" id="finished" value="Hoàn tất" name="finished" onclick="javascript: submit_comment_form();" />
								<input type="button" id="cancel" value="Thoát" name="cancel" onclick="javascript: $.fn.colorbox.close();"/>
							</td>
						</tr>
					</table>
				</div>	
			</div>
		</div>
		<!--	end COLOR BOX	-->
		<div class='text_area_ct'>		
			<span>(Bạn vui lòng gõ tiếng Việt có dấu) </span><br/>
			<textarea id="text" cols="88" rows="4" name="text" onfocus="if(this.value=='Nội dung') this.value=''" onblur="if(this.value=='') this.value='Nội dung'">Nội dung</textarea>
		</div>
		 
		<div class='button_area'>
			<a class="button" href="javascript: void(0)" id='submitbt'>
				<span>Gửi</span>
			</a>
<!--			<a class="button" href="javascript: void(0)" id='resetbt'>-->
<!--				<span>Làm lại</span>-->
<!--			</a>-->
			<div class='clear'></div>
		</div>
		<input type="hidden" value="1" name='raw' />
		<input type="hidden" value="news" name='module' />
		<input type="hidden" value="news" name='view' />
		<input type="hidden" value="save_comment" name='task' />
		<input type="hidden" value="<?php echo $data->id; ?>" name='news_id' id='news_id'  />
		<input type="hidden" value="<?php echo $return;?>" name='return'  />
	</form>
	<!-- end FORM COMMENT	-->
</div>

