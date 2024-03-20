<?php
global $tmpl;
$tmpl -> addStylesheet('popup','blocks/register/assets/css');
$tmpl -> addScript('popup','blocks/register/assets/js');  
FSFactory::include_class('fsstring');
$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'vi';  
// $tmpl -> addStylesheet('jquery-ui','libraries/jquery/jquery.ui');
$tmpl -> addScript('form');
// $tmpl -> addScript('jquery-ui','libraries/jquery/jquery.ui');

$Itemid = FSInput::get('Itemid',1);

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


<div class="popup-login-resgister hide">
	<div class="close_popup" onclick="HideLoginPopup()">
		<svg  x="0px" y="0px" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve">
		<g>
			<g>
				<path d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717    L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859    c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287    l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285    L284.286,256.002z"/>
			</g>
		</g>

		</svg>
	</div>
	<div class="tab_login">
		<div class=title>Đăng nhập</div>
		<?php if(1==1){ ?>
		<div class="social_login">
			<a class="login_fb" title="Đăng nhập bằng Facebook" href="<?php echo  htmlspecialchars($loginUrl);?>">
				<svg  width="30px" height="30px" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"/></svg>
				Đăng nhập bằng Facebook

			</a>

			<a class="login_gg" title="Đăng nhập bằng Google" href="javascript:void(0)" data-url="<?php echo $google_client-> createAuthUrl();?>" data-width="800" data-height="500" data-id="google-login" onclick="openPopupWindow(this);">
				<svg width="30px" height="30px" x="0px" y="0px"
				viewBox="0 0 23.952 23.952" style="enable-background:new 0 0 23.952 23.952;" xml:space="preserve">
				<g>
					<path d="M18.174,1.157h-2.116l0.709,0.576c0.282,0.234,0.547,0.524,0.802,0.871
					c0.252,0.346,0.468,0.749,0.646,1.205c0.176,0.457,0.266,0.979,0.266,1.566c0,0.562-0.083,1.064-0.252,1.5
					c-0.165,0.438-0.381,0.832-0.643,1.183S17.018,8.723,16.674,9l-1.06,0.811c-0.218,0.216-0.431,0.439-0.645,0.674
					c-0.21,0.231-0.317,0.527-0.317,0.884c0,0.351,0.125,0.633,0.372,0.84c0.251,0.21,0.479,0.376,0.682,0.504l1.223,0.885
					c0.337,0.29,0.653,0.582,0.957,0.878c0.302,0.295,0.574,0.614,0.815,0.957c0.236,0.345,0.427,0.723,0.561,1.136
					c0.135,0.413,0.199,0.888,0.199,1.426c0,0.75-0.182,1.481-0.551,2.188c-0.368,0.709-0.912,1.346-1.638,1.909
					c-0.724,0.564-1.621,1.015-2.691,1.353c-1.073,0.338-2.306,0.507-3.707,0.507c-1.232,0-2.302-0.125-3.207-0.378
					c-0.908-0.252-1.666-0.587-2.271-1.006c-0.605-0.418-1.057-0.895-1.353-1.432c-0.295-0.537-0.44-1.1-0.44-1.691
					c0-0.569,0.182-1.212,0.551-1.933c0.368-0.719,1.042-1.353,2.023-1.899c0.52-0.29,1.076-0.524,1.67-0.709
					c0.592-0.183,1.176-0.324,1.758-0.427c0.582-0.101,1.133-0.173,1.655-0.217c0.52-0.042,0.971-0.075,1.343-0.097
					c-0.231-0.287-0.448-0.592-0.648-0.909c-0.195-0.316-0.294-0.726-0.294-1.231c0-0.268,0.033-0.49,0.099-0.669
					c0.065-0.181,0.137-0.362,0.221-0.543c-0.169,0.021-0.344,0.037-0.527,0.047c-0.186,0.011-0.368,0.018-0.543,0.018
					c-0.906,0-1.704-0.141-2.398-0.429C7.822,10.164,7.228,9.79,6.743,9.33C6.26,8.868,5.895,8.34,5.655,7.743
					C5.41,7.148,5.29,6.544,5.29,5.931c0-0.728,0.179-1.463,0.525-2.209c0.352-0.748,0.882-1.414,1.594-2.004
					c0.978-0.75,1.993-1.224,3.051-1.421C11.515,0.1,12.499,0,13.415,0h6.935L18.174,1.157z M17.354,19.195
					c0-0.389-0.064-0.744-0.196-1.069c-0.131-0.321-0.327-0.633-0.592-0.934c-0.265-0.301-0.639-0.619-1.121-0.955
					c-0.483-0.337-1.03-0.719-1.646-1.149c-0.127-0.043-0.247-0.067-0.354-0.067H13.03c-0.086,0-0.248,0.007-0.489,0.016
					c-0.241,0.011-0.53,0.035-0.868,0.071c-0.337,0.038-0.697,0.089-1.084,0.152c-0.384,0.065-0.752,0.148-1.104,0.256
					c-0.197,0.064-0.452,0.163-0.771,0.296c-0.323,0.131-0.64,0.324-0.956,0.573c-0.317,0.249-0.59,0.568-0.817,0.95
					c-0.233,0.383-0.346,0.845-0.346,1.389c0,0.562,0.134,1.072,0.405,1.531c0.271,0.457,0.668,0.86,1.185,1.213
					c0.512,0.35,1.135,0.616,1.865,0.795c0.726,0.181,1.538,0.271,2.433,0.271c1.62,0,2.837-0.313,3.65-0.941
					S17.354,20.166,17.354,19.195z M14.668,9.079c0.381-0.373,0.615-0.773,0.697-1.2c0.083-0.425,0.124-0.782,0.124-1.067
					c0-0.564-0.086-1.179-0.255-1.846c-0.171-0.664-0.43-1.285-0.774-1.859c-0.347-0.576-0.777-1.059-1.289-1.453
					c-0.521-0.397-1.115-0.592-1.797-0.592c-0.438,0-0.872,0.099-1.298,0.294C9.65,1.553,9.295,1.802,9.021,2.099
					C8.731,2.43,8.539,2.793,8.435,3.185C8.335,3.581,8.284,3.986,8.284,4.4c0,0.521,0.083,1.105,0.244,1.748
					c0.164,0.646,0.419,1.247,0.768,1.813c0.35,0.563,0.785,1.039,1.3,1.42c0.52,0.385,1.135,0.576,1.854,0.576
					c0.423,0,0.834-0.078,1.232-0.24C14.079,9.557,14.41,9.343,14.668,9.079z"/>
				</g>
				</svg>
				Đăng nhập bằng Google
			</a>
			<span class="other">hoặc</span>
		</div>	
		<?php } ?>
		<div class="website_login">
			
			<form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="login_form" class="login_form" method="post" onsubmit="javascript: return checkFormsubmit_login();">
				<div class="row-register cf ">

					<input type="text" name="email" id="email_login" value="<?php echo isset($_COOKIE['save_login_username']) ? $_COOKIE['save_login_username'] : '' ?>" class='txt-login'  placeholder="<?php echo FSText::_('Email'); ?>" required />
				</div>
				<div class="row-register cf ">
					<input type="password" name="password" id="password_login"  class='txt-login pass' autocomplete="off"  placeholder="<?php echo FSText::_("Mật khẩu") ?>" required value="<?php echo isset($_COOKIE['save_login_password']) ? $_COOKIE['save_login_password'] : '' ?>" />
				</div>
				<div class="cls save_resetpass">
					<div class="save_login">
						<input type="checkbox" name="save_login" value="1" <?php echo isset($_COOKIE['save_login']) ? 'checked' : '' ?> />
						<label>Ghi nhớ</label>
					</div>
					<div class="reset_pass">
						<a onclick="OpenforgetPass()" href="javascript:void(0);" class="forget"><?php echo FSText::_("Quên mật khẩu") ?>?</a>
					</div>
				</div>

				<div class="wrapper-bt-register"> 
					<div class="row-register cf ">
						<input type="button" name="login" class="lg login btn-submit signin-submit" value="<?php echo FSText::_("Đăng nhập") ?>"/>
					</div>
					
					<div class="create">
						Bạn chưa có tài khoản Hải Linh
						<a onclick="OpenRegister()" class="a_register" href="javascript:void(0)" title="<?php echo FSText::_('Tạo tài khoản'); ?>">
					 		<?php echo FSText::_("Đăng ký"); ?>
					 	</a>
					</div>
				</div>
				<?php 
					$url = $_SERVER['REQUEST_URI'];
					$return = base64_encode($url);					
					?>
					<input type='hidden'  name="return" value="<?php echo $return;  ?>"/> 
					<input type="hidden" name = "module" value = "users" />
					<input type="hidden" name = "view" value = "users" />
					<input type="hidden" name = "task" value = "login_save" />
					<input type="hidden" name = "Itemid" value = "<?php echo $Itemid;?>" />
					<?php if(@$redirect)
					echo "<input type='hidden' name = 'redirect' value = '$redirect' />";  
				?> 
			</form>
		</div>
	</div>

	<div class="tab_reset_pass hide">
		<div class="title">Quên mật khẩu</div>
		<div class="divforget">
			<form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="forget_form" class="forget_form" method="post">
				<div class="form-login">
					<div class='row-register' width="183"> <input placeholder="Email" class="txt-login" type="text" name="email"/> </div>
					<div class='row-register row-register-capcha'>
						<input autocomplete="off" type="text" placeholder="<?php echo FSText::_('Mã hiển thị'); ?>"  id="txtCaptcha" value="" name="txtCaptcha"  maxlength="10" size="7" class="capcha txt-login" />
						<a href="javascript:changeCaptcha();"  title="<?php echo FSText::_('Click here to change the captcha'); ?>" class="code-view" />
							<img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
						</a>
					</div>			            
					<div class="row-register"> <input type="submit" class='submitbt btn-submit' name="submitbt" value = "<?php echo FSText::_("Đồng ý");?>"   /></div>
				</div>
				<?php 
				$url = $_SERVER['REQUEST_URI'];
				$return = base64_encode($url);					
				?>
				<input type='hidden'  name="return" value="<?php echo $return;  ?>"/>
				<input type="hidden" name = "module" value = "users" />
				<input type="hidden" name = "view" value = "users" />
				<input type="hidden" name = "task" value = "forget_save" />
			</form> 
		</div>
	</div>


	<div class="regis_user hide">
		<div class="title">Tạo tài khoản</div>
		<div class="box-register">
			<form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="register_form" class="register_form" method="post" onsubmit="javascript: return checkFormsubmit();">
				<div class="message"></div>
				<div class="form-login">
					<div class="row-register cf ">
						<input placeholder="<?php echo FSText::_('Họ và tên'); ?>" type="text" id="full_name" name="full_name" class='txtinput fr txt-login' value=""/>
					</div>
					<div class="row-register cf ">                     
						<input required placeholder="<?php echo FSText::_('Số điện thoại'); ?>" type="tel" name="telephone" id="telephone"  class='txtinput numberCheck fr txt-login' value=""/>
					</div>
					<div class="row-register cf ">
						<input placeholder="<?php echo FSText::_('Email'); ?>" type="text" id="email" name="email" class='txtinput fr txt-login' value=""/>
					</div>
					<div class="row-register cf ">
							<input required placeholder="<?php echo FSText::_('Mật khẩu'); ?>" type="password" name="password" id="password"  class='txtinput fr txt-login' autocomplete="off" />
					</div>
					
					

					<div class="row-register row-register-sl cf ">  
						<div class="date_l">
							<div class="title-t">Ngày sinh</div>
							<select class="date" name="date" id="date" >
								<option value="">Ngày</option>
								<?php for($i=1;$i<=31;$i++){ ?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
								<?php } ?>
							</select>
							<select class="month" name="month" id="month">
								<option value="">Tháng</option>
								<?php for($i=1;$i<=12;$i++){ ?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
								<?php } ?>
							</select>
							<select class="year" name="year" id="year">
								<option value="">Năm</option>
								<?php for($i=1960;$i<=2020;$i++){ ?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="date_r">
							<div class="title-t">Giới tính</div>
							<select class="sex" name="gender" id="gender">
								<option value="">Lựa chọn</option>
								<option value="1">Nam</option>
								<option value="2">Nữ</option>
							</select>
						</div>
					</div>
					<div class="clear"></div>

					<div class="input-check">
						<input type="checkbox" name="is_news_sale" value="1">
						Tôi muốn nhận được ưu đãi và khuyến mãi độc quyền từ Hải Linh
					</div>

					<div class="row-register cf ">
						<div class=" wrapper-bt-register">
							<input type="button" class='submitbt login btn-submit register-submit' name="submitbt" value = "<?php echo FSText::_('Tạo tài khoản'); ?>"   />
						</div>
					</div>

					<div class="text-bot">
						Bằng cách nhấp vào "đăng ký",tôi đồng ý với <a href="" title="Điều khoản sử dụng">Điều khoản sử dụng</a> và <a href="" title="Chính sách bảo mật">Chính sách bảo mật</a> của Hảu Linh
					</div>

				</div>
				
				<?php 
					$url = $_SERVER['REQUEST_URI'];
					$return = base64_encode($url);					
				?>
				<input type='hidden'  name="return" value="<?php echo $return;  ?>"/>
				<input type="hidden" name = "module" value = "users" />
				<input type="hidden" name = "view" value = "users" />
				<input type="hidden" name = "Itemid" value = "<?php echo $Itemid; ?>" />
				<input type="hidden" name = "task" value = "register_save" />
			</form>
			<span class="other">hoặc</span>
		</div>
		<div class="login-bot">
			Bạn đã có tài khoản <a onclick="OpenLogin()" href="javascript:void(0)"title="Đăng nhập">đăng nhập</a>
			
		</div>
	</div>
</div>
