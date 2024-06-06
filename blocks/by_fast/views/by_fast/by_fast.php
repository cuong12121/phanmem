<?php
global $tmpl,$config,$is_mobile; 
$tmpl -> addStylesheet('by_fast','blocks/by_fast/assets/css');
$tmpl -> addScript('by_fast','blocks/by_fast/assets/js');
FSFactory::include_class('fsstring');
?>

<div class="wrap-by-fast cls">
	<div class="buy_fast cls">
		<div class="title_form">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"  x="0px" y="0px" viewBox="0 0 224.418 224.418" style="enable-background:new 0 0 224.418 224.418;" xml:space="preserve">
				<path d="M1.209,120.668h14.25v103.75h193.5v-103.75h14.25v-71h-49.696c4.01-5.564,6.585-11.849,7.393-18.228  c1.164-9.188-1.549-17.837-7.442-23.73C168.491,2.738,161.561,0,153.951,0c-9.919,0-20.123,4.516-27.994,12.388  c-9.177,9.177-11.353,26.221-11.735,37.28h-4.025c-0.382-11.06-2.558-28.103-11.735-37.28C90.59,4.516,80.386,0,70.467,0  c-7.611,0-14.54,2.738-19.513,7.71c-5.894,5.894-8.606,14.543-7.442,23.73c0.808,6.379,3.383,12.664,7.394,18.228H1.209V120.668z   M136.563,22.993C141.568,17.988,148.068,15,153.951,15c2.55,0,6.165,0.576,8.906,3.317c2.628,2.628,3.753,6.618,3.167,11.237  c-0.665,5.252-3.524,10.74-7.843,15.061c-2.098,2.098-5.643,3.806-10.258,5.053h-18.667  C129.639,40.467,131.336,28.221,136.563,22.993z M119.709,64.668h88.5v41h-88.5V64.668z M119.709,122.418h74.25v87h-74.25V122.418z   M104.709,209.418h-74.25v-87h74.25V209.418z M61.561,18.317C64.303,15.576,67.917,15,70.467,15c5.883,0,12.383,2.988,17.388,7.993  c4.911,4.911,6.914,16.698,7.332,26.675H76.496c-4.616-1.247-8.162-2.956-10.259-5.054c-4.319-4.319-7.178-9.808-7.843-15.06  C57.808,24.936,58.933,20.945,61.561,18.317z M16.209,64.668h88.5v41h-88.5V64.668z"/>
			</svg>
			ĐĂNG KÝ <br> Nhận tin khuyến mãi
		</div>
		<form action="" name="buy_fast_form_1" id="buy_fast_form_1" method="" onsubmit="" >
			<div class="cls buy_fast_body">
				<input type="text" value="" placeholder="<?php echo FSText::_('Email của bạn...'); ?>" id="email_buy_fast" name="email_buy_fast" class="keyword input-text" />
			</div>
			<button  class="button-buy-fast button" id="button_open_main">Gửi</button>
			<?php 
			$url = URL_ROOT;
			$return = base64_encode($url);					
			?>
			<input type='hidden'  name="module" value="users"/>		    
			<input type='hidden'  name="view" value="users"/>
			<input type='hidden'  name="task" value="buy_fast_save"/>
			<input type='hidden'  name="Itemid" value="10"/>
			<input type='hidden'  name="return" value="<?php echo $return;  ?>"/>
		</form>
	</div>
</div>