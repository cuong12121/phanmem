<?php 
	$url = $_SERVER['REQUEST_URI'];
	$return = base64_encode($url);
	$max_level = 5;
?>
<div style="display:none" itemscope="" itemtype="http://schema.org/Person">
<span class="fn" itemprop="name">VinhPham</span>
<meta itemprop="homeLocation" content="Vietnam">
<p><span class="title">SEO</span> at <span class="org"></span></p>
<span class="street-address"></span>
<span class="locality">H� N?i</span>, <span class="region">HN</span>
<span class="postcode">100000</span>
</div>
<div style="display:none" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
<span itemprop="ratingValue">4,5</span> stars, based on <span itemprop="reviewCount">425</span>reviews</div>
<div class='comments'>
	<!-- FORM COMMENT	-->
	<div class='comment_form_title' style=" font-weight:bold;"><i class="fa fa-comments-o" aria-hidden="true"></i> Gửi bình luận</div>
	<form action="#" method="post" name="comment_add_form" id='comment_add_form' class='form_comment'>
		<p class='name_email'> 
			<input type="text" id="comment_name"  required name="name" size="40"  placeholder="Họ và tên"/>
			<input style="float:right" type="email"  required id="comment_email"  name="email" size="40" placeholder="Email của bạn" />
		</p>
		<!--<p class='captcha'>
			<input type="text" id="txtCaptcha" required  name="txtCaptcha"  maxlength="10" size="23"  placeholder="Mã kiểm tra" />
			<a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" >
				<img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
			</a>
		</p>	-->
		<textarea id="comment_text" cols="84" rows="5" name="text" required placeholder="Nội dung" minlength="1"></textarea>
		 
		<p class='button_area'>
		   <!-- <a rel="nofollow" class="button" href="javascript: void(0)" id='commentbt'>
				cc
			</a>-->
           <button rel="nofollow" class="button" id='commentbt'><span>Gửi</span></button>
           <script>
           //$('#comment_add_form').submit(function(e){
			   // validate			   
			//   alert( "Cảm ơn bạn đã gửi bình luận" );
		   //});
           </script>
			<a rel="nofollow" class="button" href="javascript: void(0)" id='resetbt'>
				<span>Làm lại</span>
			</a>
			<div class='clear'></div>
            <P><i>Lưu ý: Chỉ những tài khoản có biểu tượng Quản trị viên mới là đại diện của chúng tôi trả lời khách hàng.</i></P>
		</p>
		<input type="hidden" value="0" name='raw' />
		<input type="hidden" value="1" name='ajax' />
		<input type="hidden" value="products" name='module' />
		<input type="hidden" value="product" name='view' />
		<input type="hidden" value="save_comment" name='task' />
		<input type="hidden" value="<?php echo $data->id; ?>" name='record_id' id='record_id'  />
		<input type="hidden" value="<?php echo $return;?>" name='return'  />
	</form>
	<!-- end FORM COMMENT	-->
    
    
    <?php
		// cho nay la de in comment 
		$num_child = array();
		$wrap_close = 0;
		
		if($comments){
		?>
			<div class="add-task">
					 <div class='comment_form_title_send'><strong><i class="fa fa-commenting-o" aria-hidden="true"></i>NHẬN XÉT SẢN PHẨM: <?php echo $data->name; ?><i>(<?php echo $data->comments_total; ?> Nhận xét & Bình luận)</i></strong></div>
					 <div class='clear'> </div>
			</div>
			<div id="commem_lindo" class='comments_contents'> 
		<?php 	
			foreach ($comments as $item){
		    $adminStyle = 'regularUser';
			if($item->name == 'MSmobile') $adminStyle = 'MSmobile';
			$is_reply = ($item->parent_id) ? "item-reply" : "" ;
		?>
			<div class='comment-item <?php echo $is_reply; ?> item-<?php echo $adminStyle;?> comment-item-<?php echo $item -> id;?>'>
				<div class="avata_cmicon avata_<?php echo $adminStyle;?>"></div>
                <div class="comment_ct"> 
				<!--	CONTENT OF COMMENTS		-->
				<span class='name'><strong><?php echo $item -> name; ?></strong></span>
				<!--<p class='email'><?php echo $item -> email?></p>-->
				<div class='comment_content'>
					<?php echo $item -> comment; ?>
				</div>
                <p class="commemn_ff">
                <span class="traloi"><a rel="nofollow" class="show_reply_form" href="javascript: void(0)">Trả lời</a></span>
                <span class="lido_like"><a rel="nofollow" href="javascript: void(0)">Thích <i class="fa fa-thumbs-up" aria-hidden="true"></i></a></span>
                <span class='date'><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d/m/Y H:i',strtotime($item -> created_time)); ?></span>
                </p>
				<div class="form_comment form_comment_reply" style="display:none;">  
						   <table style="width:100%">
							  <tr>
								<td  style="width:50%"><input type="text" name="name" class="name_comment" style="width:100%" placeholder="Họ và tên" /> </td>
								<td  style="width:50%"><input type="text" name="email" class="email_comment" style="width:100%"  placeholder="Email của bạn" /> </td>
							  </tr>
							  <tr>
								<td colspan="2"> 
									<textarea  style="width:100%" name="text" class="text_comment" placeholder="Nội dung"></textarea>
								</td>
							  </tr>
							  <tr> 
								 <td colspan="2">
								 <input type="hidden" value="<?php echo $item -> id;?>" name='comment_id' class='comment_parrent'  />
								 <input type="button" class="btnSendComment" value="Gửi bình luận">
								 </td>
								 
							  </tr>
						   </table> 
				</div>
                </div>
				<!--	end CONTENT OF COMMENTS		-->
			</div>
			<div class='clear'></div>
			<?php
			}
			?>
			</div>
			
			
		<div id='commentTempl' class="comment-item item-reply" style="display:none">
				<div class="avata_cmicon "></div>
                <div class="comment_ct"> 
				<!--	CONTENT OF COMMENTS		-->
				<span class='name'><strong></strong></span> 
				<div class='comment_content'>
					 
				</div>
                <p class="commemn_ff">
                <span class="traloi"><a rel="nofollow" class="show_reply_form" href="javascript: void(0)">Trả lời</a></span>
                <span class="lido_like"><a rel="nofollow" href="javascript: void(0)">Thích <i class="fa fa-thumbs-up" aria-hidden="true"></i></a></span>
                <span class='date'><i class="fa fa-calendar" aria-hidden="true"></i></span>
                </p>
				<div class="form_comment form_comment_reply" style="display:none;"> 
						<div>
						   <table style="width:100%">
							  <tr>
								<td  style="width:50%"><input type="text" name="name" class="name_comment" style="width:100%" placeholder="Họ và tên" /> </td>
								<td  style="width:50%"><input type="text" name="email" class="email_comment" style="width:100%"  placeholder="Email của bạn" /> </td>
							  </tr>
							  <tr>
								<td colspan="2"> 
									<textarea  style="width:100%" name="text" class="text_comment" placeholder="Nội dung"></textarea>
								</td>
							  </tr>
							  <tr> 
								 <td colspan="2">
								 <input type="hidden" value="COMMENTID" name='comment_id' class='comment_parrent'  />
								 <input type="button" class="btnSendComment" value="Gửi bình luận">
								 </td>
								 
							  </tr>
						   </table>
						</div>
				</div>
                </div>
							<!--	end CONTENT OF COMMENTS		-->
			</div>
			<?php  
		}
		?>
</div>

