<?php 
require(PATH_BASE.'libraries'.DS.'facebook_sdk'.DS.'autoload.php');
$fb = new Facebook\Facebook([
	'app_id' => FACEBOOK_ID,
	'app_secret' => APP_SECRET,
	'default_graph_version' => 'v2.2',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email','public_profile'];// Optional permissions
$loginUrl = $helper->getLoginUrl(URL_ROOT.'face_login.html', $permissions);

require(PATH_BASE.'libraries'.DS.'google'.DS.'gconfig.php');

?>


<div id="form-login" class="overflow-hidden shadow hidden">
	<div class="text-center">
		<span class="d-block m-3">Thanh toán đơn hàng chỉ trong 1 bước với</span>
		<a href="javascript:open_oauth('Facebook')" class="btn btn-login fb current">
			<i class="fa fa-facebook">
				<svg width="18px" height="18px" aria-hidden="true" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 512" class="svg-inline--fa fa-facebook-f fa-w-9"><path fill="#fff" d="M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229" class=""></path></svg>
			</i>
			<span>Facebook</span>
		</a>
		<a href="javascript:open_oauth('Google')" class="btn btn-login go current">
			<i class="fa fa-google">
				<svg fill="#fff" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="18px" height="18px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
				<g>
					<g id="glass">
						<path d="M286.875,229.5v63.75h150.45c-15.3,89.25-86.7,153-175.95,153c-104.55,0-191.25-86.7-191.25-191.25    s86.7-191.25,191.25-191.25c53.55,0,99.45,22.95,132.6,58.65l45.9-45.9c-45.9-45.9-107.1-76.5-178.5-76.5    c-140.25,0-255,114.75-255,255s114.75,255,255,255s242.25-114.75,242.25-255v-25.5H286.875z"/>
					</g>
				</g>
				</svg>
			</i>
			<span>Google</span></a>
		<a href="javascript:open_oauth('Zalo')" class="btn btn-login zl current">
			<i class="icons icon-zalo">
				<svg width="20px" height="20px" x="0px" y="0px" viewBox="0 0 512.007 512.007" style="enable-background:new 0 0 512.007 512.007;" xml:space="preserve">
				<circle style="fill:#E6EFF4;" cx="256.003" cy="256.003" r="256.003"></circle>
				<path style="fill:#B6D1DD;" d="M385.581,107.256L385.581,107.256c-5.101-5.102-12.148-8.258-19.932-8.258H146.354
				c-15.567,0-28.187,12.619-28.187,28.187v219.295c0,7.785,3.156,14.832,8.258,19.933l0,0l145.105,145.105
				C405.682,503.489,512.001,392.169,512.001,256c0-8.086-0.393-16.081-1.126-23.976L385.581,107.256z"></path>
				<path style="fill:#41A0D7;" d="M365.647,98.999H146.353c-15.567,0-28.187,12.619-28.187,28.187v219.294
				c0,15.567,12.619,28.187,28.187,28.187h43.971v38.334l53.377-38.334h121.946c15.567,0,28.187-12.619,28.187-28.187V127.185
				C393.834,111.618,381.215,98.999,365.647,98.999z"></path>
				<path style="fill:#FFFFFF;" d="M393.834,340.942v-44.17c-5.73-5.85-13.714-9.484-22.55-9.484h-64.188l86.738-118.175V131.24
				c-4.466-3.988-10.304-6.31-16.5-6.31h-131.2c-17.435,0-31.57,14.135-31.57,31.57s14.135,31.57,31.57,31.57h55.168L212,311.089
				c-5.474,7.539-6.255,17.512-2.024,25.812c4.231,8.3,12.76,13.526,22.077,13.526h139.232
				C380.121,350.426,388.104,346.792,393.834,340.942z"></path>
				</svg>
			</i> 
			<span>Zalo</span>
		</a>
	</div>

	<hr>

	<form action="<?php echo FSRoute::_("index.php?module=users&task=login") ?>" method="post" name="login_form" class="login_form" onsubmit="javascript: return check_submit_form();">
		<input type="hidden" name="login" id="login" value="yes">
		<input type="hidden" id="return_url" name="return_url" value="https://shop.nagakawa.com.vn/cart">
		<table cellpadding="5" cellspacing="0" width="100%">
			<tbody>
				<tr>
					<td>Email đăng nhập</td>
					<td>
						<input type="text" name="email" id="email_login" value="<?php echo isset($_COOKIE['save_login_username']) ? $_COOKIE['save_login_username'] : '' ?>" class='form-control'  placeholder="<?php echo FSText::_('Email'); ?>" required />
					</td>
				</tr>
				<tr>
					<td>Mật khẩu</td>
					<td>
						<input type="password" size="25" name="password" id="password" class="form-control">
						<input type="password" name="password" id="password_login"  class='form-control' autocomplete="off"  placeholder="<?php echo FSText::_("Mật khẩu") ?>" required value="<?php echo isset($_COOKIE['save_login_password']) ? $_COOKIE['save_login_password'] : '' ?>" />
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<div class="reset-pass">Quên mật khẩu? Khôi phục mật khẩu <a href="/quen-mat-khau" class="green">tại đây</a></div>
						<input type="submit" value="Đăng nhập" class="btn btn-primary d-block" style="width:100%;">
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name = "module" value = "users" />
		<input type="hidden" name = "view" value = "users" />
		<input type="hidden" name = "return" value = "<?php echo base64_encode($_SERVER['REQUEST_URI']) ?>" />
		<input type="hidden" name = "task" value = "login_save" />
		<input type="hidden" name = "is_continue" id='is_continue' value = "<?php echo $session_order ? 1:0?>" />
	</form>
</div>
<!-- end form-login -->