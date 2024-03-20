<form action="javascript:void(0);" method="post" name="comment_add_form" id='comment_add_form' class='form_comment cls' class="form_comment" onsubmit="javascript: submit_comment();return false;">
			<!-- <label class="label_form">Bình luận</label> -->
			<div class="tab-title">
				<h3><span>Hỏi đáp <span>sản phẩm</span></span></h3>
			</div>
			<?php if($module!="products" && $module != "repairs"){ ?>
				<?php include 'comments_rate.php'; ?>
			<?php } ?>
			
			<div class="_textarea">
				<textarea name="content" id="cmt_content"   placeholder="Viết câu hỏi của bạn..."></textarea>
			</div>
			
			<button type="button" class="btn-comment-mb">Gửi câu hỏi  </button>


			<div class="wrap_r cls"> 
				<div class="title-mb">
					Thông tin người gửi
					<span class="close-md-comment"><svg height="16px" viewBox="0 0 64 64" enable-background="new 0 0 64 64">
  <g>
    <path fill="black" d="M28.941,31.786L0.613,60.114c-0.787,0.787-0.787,2.062,0,2.849c0.393,0.394,0.909,0.59,1.424,0.59   c0.516,0,1.031-0.196,1.424-0.59l28.541-28.541l28.541,28.541c0.394,0.394,0.909,0.59,1.424,0.59c0.515,0,1.031-0.196,1.424-0.59   c0.787-0.787,0.787-2.062,0-2.849L35.064,31.786L63.41,3.438c0.787-0.787,0.787-2.062,0-2.849c-0.787-0.786-2.062-0.786-2.848,0   L32.003,29.15L3.441,0.59c-0.787-0.786-2.061-0.786-2.848,0c-0.787,0.787-0.787,2.062,0,2.849L28.941,31.786z"/>
  </g>
</svg></span>
				</div>           
				<div class="wrap_loginpost">            
					<aside class="_right">                
						<div>           
							<input class="txt_input" required name="name" type="text" placeholder="Họ tên (bắt buộc)"  id="cmt_name"  autocomplete="off" value="<?php echo !empty($addess_book) ? @$addess_book->full_name : '' ?>">
						</div>
						<div>  
							<input class="txt_input" required name="email" type="email" placeholder="Email (bắt buộc)" id="cmt_email"  value="<?php echo !empty($addess_book) ? @$addess_book->email : '' ?>" >     
						</div>             
						
					</aside>        
				</div>
				<div class="wrap_submit mbl">
					<div class="pull-right clearfix">
						<input type="submit" class="_btn_comment" value="Gửi bình luận">  
					</div> 
				</div>  
			</div>  
			<input type="hidden" value="comments" name='module' />
			<input type="hidden" value="comments" name='view' />
			<input type="hidden" value="<?php echo $module;?>" name='type' id="_cmt_type" />

			<!-- <input type="hidden" value="<?php echo $data -> id;?>" name='record_id' id="record_id" /> -->
			<input type="hidden" value="<?php echo $module;?>" name='_cmt_module' id="_cmt_module" />
			<input type="hidden" value="<?php echo $view;?>" name='_cmt_view' id="_cmt_view" />
			<input type="hidden" value="save_comment" name='task' />
			<input type="hidden" value="<?php echo $data -> id;?>" name='record_id' id="_cmt_record_id" />
			<input type="hidden" value="<?php echo $return;?>" name='return'  id="_cmt_return"  />
			<input type="hidden" name="linkurlall" id="cmt_linkurlall" value="<?php echo $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>" />
			<input type="hidden" value="<?php echo '/index.php?module=comments&view=comments&type='.$module.'&task=save_comment&raw=1'; ?>" name="return" id="link_reply_form" />
		</form>