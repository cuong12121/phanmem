<?php
global $tmpl,$config,$is_mobile; 
$tmpl -> addScript('form');
$tmpl -> addStylesheet('popup','blocks/by_fast/assets/css');
$tmpl -> addScript('popup','blocks/by_fast/assets/js');
FSFactory::include_class('fsstring');
?>



<div class="form-by-fast-popup cls">
	<div class="block_title">
		<span>Đăng ký nhận thông tin</span>
	</div>

	<form  action="" name="buy_fast_form_popup" id="buy_fast_form_popup" method="post">
		
			<div class="ip-top">
				<input type="text" required value="" placeholder="Họ tên(*):" id="name_buy_fast_popup" name="name_buy_fast_popup"/>

				<input type="text" required value="" placeholder="Số điện thoại(*):" id="telephone_buy_fast_popup" name="telephone_buy_fast_popup"/>

				<input type="text" required value="" placeholder="Email(*):" id="email_buy_fast_popup" name="email_buy_fast_popup"/>

			
				<input type="text" required value="" id="mesegase_buy_fast_popup" placeholder="Tin nhắn" name="mesegase_buy_fast_popup" />
			
			</div>

			<div class="content-r">
				<input type="button" class="button-buy-fast button" value="<?php echo FSText::_('Đăng ký'); ?>" id="submit_btn_popup" onclick="submit_form_buy_fast_popup()" />
					
				
			</div>

		<?php 
			$url = $_SERVER['REQUEST_URI'];
			$return = base64_encode($url);					
		?>
		<input type='hidden'  name="module" value="users"/>		    
		<input type='hidden'  name="view" value="users"/>
		<input type='hidden'  name="task" value="buy_fast_save_popup"/>
		<input type='hidden'  name="Itemid" value="10"/>
		<input type='hidden'  name="return" value="<?php echo $return;  ?>"/>
	</form>
	<div class="clear"></div>
	
</div>