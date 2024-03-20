<?php $return = base64_encode($_SERVER['REQUEST_URI']); ?>
<div class='comments'>
				
		<?php 
		$num_child = array();
		$wrap_close = 0;
		if($comments){
		?>
			<div class="add-task">
					<div class='comment_form_title_send' ><?php echo $total_comment;?> Bình luận</div>
					 <div class='clear'> </div>
			</div>
			<div class='comments_contents'>
		<?php 	
			foreach ($comments as $item){
		?>
			<div class='comment-item comment-item-<?php echo $item -> id;?>'>
				<div class='member_img'>
					<?php if(isset($members_comments[$item -> user_id]) && $members_comments[$item -> user_id] -> image){?>
						<img width="27" src="<?php echo URL_ROOT.$members_comments[$item -> user_id] -> image ?>" alt="<?php echo $item -> username; ?>" />
					<?php }else{ ?>
						<img width="27" src="<?php echo URL_ROOT.'images/no-avatar.jpg'; ?>" alt="<?php echo $item -> username; ?>" />
					<?php }?>
				</div>
				<div class='comment_item_r'>
					<!--	CONTENT OF COMMENTS		-->
					<span class='name'><?php echo $item -> name; ?></span>
					<span class='date'>(nhận xét lúc: <?php echo date('d/m/Y H:i',strtotime($item -> created_time)); ?>)</span>
	<!--				<p class='email'><?php echo $item -> email?></p>-->
					<div class='comment_content'>
						<?php echo $item -> comment; ?>
					</div>
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
	<?php if(isset($_COOKIE['user_id']) && $_COOKIE['user_id']){?>
	<form action="#" method="post" name="comment_add_form" id='comment_add_form' class='form_comment'>
		<div class='member_img'>
			<img width="27" src="<?php echo URL_ROOT.'images/no-avatar.jpg'; ?>" alt="<?php echo $item -> username; ?>" />
		</div>
		<div class='comment_form'>
			<textarea id="text-comment" cols="64" rows="5" name="text-comment" onfocus="if(this.value=='Nội dung') this.value=''" onblur="if(this.value=='') this.value='Nội dung'">Nội dung</textarea>
			<p class='button_area'>
				<a class="button" href="javascript: void(0)" id='submitbt_comment'>
					<span>Gửi bình luận</span>
				</a>
				<div class='clear'></div>
			</p>
		</div>
		<div class='clear'></div>
		<input type="hidden" value="1" name='raw' />
		<input type="hidden" value="products" name='module' />
		<input type="hidden" value="product" name='view' />
		<input type="hidden" value="save_comment" name='task' />
		<input type="hidden" value="<?php echo $data->id; ?>" name='record_id' id='record_id'  />
		<input type="hidden" value="<?php echo $return;?>" name='return'  />
	</form>
	<?php }else{?>
		<?php 
				$url = FSRoute::_('index.php?module=users&view=users&task=login&Itemid='.$Itemid.'&redirect='.$return);
		?>
			<br/>
		<div class='require_login'>	Hãy <a href="<?php echo $url; ?>" >đăng nhập</a>  để được bình luận</div>
	<?php }?>
	<!-- end FORM COMMENT	-->
</div>

