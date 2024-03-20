<?php 
if(!isset($_COOKIE['user_id'])){
$tmpl -> addScript('form');
$tmpl -> addScript('cart','modules/products/assets/js');
?>
<div class="login_form_area">
	<div class="form_label"><?php echo FSText::_('Đăng nhập'); ?></div>
	<div class="form_desc"><?php echo FSText::_('Hãy đăng nhập để thanh toán và tích điểm'); ?></div>
	
	<form action="<?php echo FSRoute::_("index.php?module=users&task=login") ?>" method="post" name="login_form" class="login_form" onsubmit="javascript: return check_submit_form();">
		<div class="tr">
			<div class="td_value">
				<input class="txtinput input_text" placeholder="Tên truy nhập" type="text" name="username" id='username'    />
			</div>
		</div>	
		<div class="tr">
			<div class="td_value">
				<input  class="txtinput input_text" placeholder="Mật khẩu" type="password" name="password" id='password'   />
			</div>
		</div>	
		<div class="tr">
			<div class="td_value center">
				<button type="submit" class="button"><?php echo FSText::_('Đăng nhập'); ?></button>
			</div>
		</div>
		<div class="tr other_task">
			<div class="td_value center">
				<a href='<?php echo FSRoute::_('index.php?module=users&view=users&task=register&Itemid=12'); ?>'><?php echo FSText::_('Đăng ký thành viên'); ?></a><span>|</span>
				<a href="<?php echo FSRoute::_("index.php?module=users&task=forget&Itemid=8");?>" title="" class="forget-pass" ><?php echo FSText::_('Quên mật khẩu'); ?></a>
			</div>
			
			
		</div>
		
		
		<input type="hidden" name = "module" value = "users" />
		<input type="hidden" name = "view" value = "users" />
		<input type="hidden" name = "return" value = "<?php echo base64_encode($_SERVER['REQUEST_URI']) ?>" />
		<input type="hidden" name = "task" value = "login_save" />
		<input type="hidden" name = "is_continue" id='is_continue' value = "<?php echo $session_order ? 1:0?>" />
	</form>
	
</div>
<!--	end LOGIN FORM		-->


<?php } ?>