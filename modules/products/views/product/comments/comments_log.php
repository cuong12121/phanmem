<div class='comments'>
				
		<?php 
		$num_child = array();
		$wrap_close = 0;
		if($comments){
		?>
			<div class="add-task">
					<div class='comment_form_title_send' >Ý kiến người dùng</div>
					 <div class='clear'> </div>
			</div>
			<div class='comments_contents'>
		<?php 	
			foreach ($comments as $item){
		?>
			<div class='comment-item comment-item-<?php echo $item -> id;?>'>
				
				<!--	CONTENT OF COMMENTS		-->
				<span class='name'><?php echo $item -> name; ?></span>
				<span class='date'>(nhận xét lúc: <?php echo date('d/m/Y H:i',strtotime($item -> created_time)); ?>)</span>
<!--				<p class='email'><?php echo $item -> email?></p>-->
				<div class='comment_content'>
					<?php echo $item -> comment; ?>
				</div>
				<!--	end CONTENT OF COMMENTS		-->
			</div>
			<div class='clear'></div>
			<?php
			}
			?>
			</div>
			<?php 
		}
		?>
	
	
	<!-- FORM COMMENT	-->
	<div class='comment_form_title' >Gửi bình luận</div>
		<?php if(isset($_COOKIE['user_id']) && $_COOKIE['user_id']){?>
			<form action="#" method="post" name="comment_add_form" id='comment_add_form' class='form_comment'>
				<textarea id="text-comment" cols="64" rows="5" name="text-comment" onfocus="if(this.value=='Nội dung') this.value=''" onblur="if(this.value=='') this.value='Nội dung'">Nội dung</textarea>
				 
				<p class='button_area'>
					<a class="button" href="javascript: void(0)" id='submitbt'>
						<span>Gửi</span>
					</a>
					<a class="button" href="javascript: void(0)" id='resetbt'>
						<span>Làm lại</span>
					</a>
					<div class='clear'></div>
				</p>
				<input type="hidden" value="1" name='raw' />
				<input type="hidden" value="products" name='module' />
				<input type="hidden" value="product" name='view' />
				<input type="hidden" value="save_comment" name='task' />
				<input type="hidden" value="<?php echo $data->id; ?>" name='record_id' id='record_id'  />
				<input type="hidden" value="<?php echo $return;?>" name='return'  />
			</form>
		<?php }else{ ?>
			<?php 
				$redirect = base64_encode($_SERVER['REQUEST_URI']);
				$url = FSRoute::_('index.php?module=users&view=users&task=login&Itemid='.$Itemid.'&redirect='.$redirect);
			?>
			<div>Hãy <a href="<?php echo $url; ?>" >đăng nhập</a>  để được bình luận</div>
		<?php }?>
	<!-- end FORM COMMENT	-->
</div>

