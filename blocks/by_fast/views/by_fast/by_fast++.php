<?php
	global $tmpl,$config,$is_mobile; 
	$tmpl -> addStylesheet('by_fast','blocks/by_fast/assets/css');
	FSFactory::include_class('fsstring');
?>

<div class="wrap-by-fast cls">
	<div class="phone-left">
			<div class="text1">Đăng ký ngay</div>
			<div class="text2">Để nhận ưu đãi và chọn vị trí tốt nhất</div>
			<div class="hotline"><a href="tel:<?php echo  $config['hotline1']?>">Hotline: <?php echo  $config['hotline1']?></a></div>
			<div class="website"><a href="">Website: <?php echo  $config['website']?></a></div>
			<div class="adress">Địa chỉ: <?php echo  $config['adress']?></div>

	</div>

	<div class="buy_fast cls">


		<div class="">
			<form action="" name="buy_fast_form" id="buy_fast_form" method="post" onsubmit="javascript: return submit_form_buy_fast();" >
				<div class="cls buy_fast_body">
					<table>
						<tr>
							<td width="100px"><?php echo FSText::_('Họ và tên*:'); ?></td>
							<td width="200px"><input type="text" value="" placeholder="" id="name_buy_fast" name="name_buy_fast" class="keyword input-text" /></td>
						</tr>
						<tr>
							<td><?php echo FSText::_('Email*:'); ?></td>
							<td><input type="text" value="" placeholder="" id="email_buy_fast" name="email_buy_fast" class="keyword input-text" /></td>
						</tr>
						<tr>
							<td><?php echo FSText::_('Số điện thoại*:'); ?></td>
							<td><input type="text" value="" placeholder="" id="telephone_buy_fast" name="telephone_buy_fast" class="keyword input-text" /></td>
						</tr>
						<tr>
							<td><?php echo FSText::_('Tin nhắn:'); ?></td>
							<td><input type="text" value="" placeholder="" id="mes_buy_fast" name="mes_buy_fast" class="keyword input-text" /></td>
						</tr>
					</table>
						<table>
						<tr>
							<td width="300px"><input type="text" required value="" placeholder="Họ và tên*:" id="name_buy_fast" name="name_buy_fast" class="keyword input-text" /></td>
						</tr>
						<tr>
							<td><input type="email" value="" required placeholder="Email*:" id="email_buy_fast" name="email_buy_fast" class="keyword input-text" /></td>
						</tr>
						<tr>
							<td><input type="text" value="" required placeholder="Số điện thoại*:" id="telephone_buy_fast" name="telephone_buy_fast" class="keyword input-text" /></td>
						</tr>
							<tr>
							<td><input type="text" value="" placeholder="Tin nhắn" id="mes_buy_fast" name="mes_buy_fast" class="keyword input-text" /></td>
						</tr>
					</table>
					
					<button type="submit" class="button-buy-fast button">

<svg id="Capa_1" x="0px" y="0px" width="15px" height="15px"
	 viewBox="0 0 334.5 334.5" style="enable-background:new 0 0 334.5 334.5;" xml:space="preserve">
<path d="M332.797,13.699c-1.489-1.306-3.608-1.609-5.404-0.776L2.893,163.695c-1.747,0.812-2.872,2.555-2.893,4.481
	s1.067,3.693,2.797,4.542l91.833,45.068c1.684,0.827,3.692,0.64,5.196-0.484l89.287-66.734l-70.094,72.1
	c-1,1.029-1.51,2.438-1.4,3.868l6.979,90.889c0.155,2.014,1.505,3.736,3.424,4.367c0.513,0.168,1.04,0.25,1.561,0.25
	c1.429,0,2.819-0.613,3.786-1.733l48.742-56.482l60.255,28.79c1.308,0.625,2.822,0.651,4.151,0.073
	c1.329-0.579,2.341-1.705,2.775-3.087L334.27,18.956C334.864,17.066,334.285,15.005,332.797,13.699z"/>
<g>
</svg>
&nbsp;
<?php echo FSText::_('Gửi đi'); ?>
					</button>

					</div>
					<?php 
					$url = $_SERVER['REQUEST_URI'];
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
</div>