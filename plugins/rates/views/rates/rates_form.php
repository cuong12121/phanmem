<form action="javascript:void(0);" method="post" name="rate_add_form" id='rate_add_form' class='form_rate hide_form cls' class="form_rate" onsubmit="javascript: submit_rate();return false;">
	
	<?php include 'rates_rate.php'; ?>
	<div class="wraper_form_rate hide">
		<div class="_textarea">
			<textarea name="content" id="rate_content"   placeholder="Nhập đánh giá về sản phẩm(Tối thiểu 30 ký tự)" onkeyup="countTxtRating()"></textarea>
			<div class="extCt hide">
                <span class="ckt"></span>
            </div>
		</div>

		
		<!-- <input type="button" class="btn-rate-mb" value="Gửi bình luận">   -->
		<div class="wrap_rate cls"> 
       
			<div class="wrap_loginpost">            
				<aside class="_right">                
					<div>           
						<input class="txt_input" required name="name" type="text" placeholder="Họ tên (bắt buộc)"  id="rate_name"  autocomplete="off" value="<?php echo @$addess_book ? $addess_book->full_name :  '' ?>">
					</div>
					<div>  
						<input class="txt_input" required name="email" type="email" placeholder="Email (bắt buộc)" id="rate_email"  value="<?php echo @$addess_book ? $addess_book->email : '' ?>" >     
					</div>  
					<div class="wrap_submit mbl">
				<div class="pull-right clearfix">
					<input type="submit" class="_btn_rate" value="Gửi đánh giá">  
				</div> 
			</div>            
					
				</aside>        
			</div>
			 
		</div>  
		<div class="MsgRt"></div>
		<input type="hidden" value="rates" name='module' />
		<input type="hidden" value="rates" name='view' />
		<input type="hidden" value="<?php echo $module;?>" name='type' id="_rate_type" />

		<input type="hidden" value="<?php echo $data -> id;?>" name='record_id' id="record_id" />
		<input type="hidden" value="<?php echo $module;?>" name='_rate_module' id="_rate_module" />
		<input type="hidden" value="<?php echo $view;?>" name='_rate_view' id="_rate_view" />
		<input type="hidden" value="save_rate" name='task' />
		<input type="hidden" value="<?php echo $data -> id;?>" name='record_id' id="_rate_record_id" />
		<input type="hidden" value="<?php echo $return;?>" name='return'  id="_rate_return"  />
		<input type="hidden" name="linkurlall" id="linkurlall" value="<?php echo $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>" />
		<input type="hidden" value="<?php echo '/index.php?module=rates&view=rates&type='.$module.'&task=save_rate&raw=1'; ?>" name="return" id="link_reply_rate" />
	</div>
</form>