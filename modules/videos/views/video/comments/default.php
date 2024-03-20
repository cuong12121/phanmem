<?php 
	$url = $_SERVER['REQUEST_URI'];
	$return = base64_encode($url);
	$max_level = 1;
?>
<div class='news_comments'>
				
		<?php 
		$num_child = array();
		$wrap_close = 0;
		if($comments){
		?>
			<div class="add-task">
					<h5 class='comment_form_title_send' ><img src="<?php echo URL_ROOT.'images/comment-icon.png';?>" alt="Ý kiến bạn đọc" title="Ý kiến bạn đọc" />Ý kiến bình luận</h5>

					 <div class='clear'> </div>
			</div>
			<div class='comments_contents'>
		<?php 	
			foreach ($comments as $item){
		?>
			<div class='comment-item comment-item-<?php echo $item -> id;?>'>
				
				<!--	CONTENT OF COMMENTS		-->
				<span class='name'><?php echo $item -> name; ?></span>
				<span class='date'>(<?php echo date('d/m/Y H:i',strtotime($item -> created_time)); ?>)</span>
<!--				<p class='email'><?php echo $item -> email?></p>-->
				<div class='comment_content'>
					<?php echo $item -> comment; ?>
				</div>
				<!--	end CONTENT OF COMMENTS		-->
			</div>
			<?php
			}
			?>
			</div>
			<?php 
		}
		?>
	
	
	<!-- FORM COMMENT	-->
	<h5 class='comment_form_title' ><img src="<?php echo URL_ROOT.'modules/news/assets/images/1375436981_comment.png';?>" alt="tag-icon" title="tag-icon" />Gửi bình luận</h5>
	<form action="#" method="post" name="news_comment_add_form" id='news_comment_add_form' >
		<p class='name_email'>
			<input type="text" id="name" value="Họ tên" name="name" size="40"  onfocus="if(this.value=='Họ tên') this.value=''" onblur="if(this.value=='') this.value='Họ tên'"/>
			<input type="text" id="email" value="Email" name="email" size="40" onfocus="if(this.value=='Email') this.value=''" onblur="if(this.value=='') this.value='Email'" />
		</p>
		<p class='captcha'>
			<input type="text" id="txtCaptcha" value="Mã kiểm tra" name="txtCaptcha"  maxlength="10" size="23" onfocus="if(this.value=='Mã kiểm tra') this.value=''" onblur="if(this.value=='') this.value='Mã kiểm tra'" />
			<a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" >
				<img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
			</a>
		</p>	
		<textarea id="text" cols="84" rows="5" name="text" onfocus="if(this.value=='Nội dung') this.value=''" onblur="if(this.value=='') this.value='Nội dung'">Nội dung</textarea>
		 
		<p>
			<a class="button" href="javascript: void(0)" id='submitbt'>
				<span>Gửi</span>
			</a>
			<a class="button" href="javascript: void(0)" id='resetbt'>
				<span>Làm lại</span>
			</a>
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

