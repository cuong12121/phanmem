<script type='text/javascript'>
	(function()
	{
		if( window.localStorage )
		{
			if( !localStorage.getItem('firstLoad') )
			{
				localStorage['firstLoad'] = true;
				window.location.reload();
			}  
			else
				localStorage.removeItem('firstLoad');
		}
	})();
</script>

<?php


global $tmpl;
// echo fSdecode($_COOKIE['code_gt']);
// die;
$tmpl -> addStylesheet('default','blocks/register/assets/css');
$tmpl -> addScript('default','blocks/register/assets/js');  
FSFactory::include_class('fsstring');

$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'vi';  
$tmpl->setTitle(FSText::_("Đăng ký thành viên"));
//$tmpl -> addStylesheet("font-awesome","templates/default/css/fonts/font-awesome-4.7.0/css");
$tmpl -> addStylesheet("users_register","modules/users/assets/css");
$tmpl -> addStylesheet('jquery-ui','libraries/jquery/jquery.ui');
$tmpl -> addScript('form');
$tmpl -> addScript('jquery-ui','libraries/jquery/jquery.ui');
// $tmpl -> addScript('datetime','modules/users/assets/js');
if($lang == 'en'){
	$tmpl -> addScript('users_register_en','modules/users/assets/js');
}else{
	// $tmpl -> addScript('users_register','modules/users/assets/js');  
}
// $tmpl -> addScript2('https://sdk.accountkit.com/en_US/sdk.js'); 
$Itemid = FSInput::get('Itemid',1);


require(PATH_BASE.'libraries'.DS.'facebook_sdk'.DS.'autoload.php');
$fb = new Facebook\Facebook([
  'app_id' => FB_APP_id, // Replace {app-id} with your app id
  'app_secret' => FB_APP_SECRET,
  'default_graph_version' => 'v2.2',
]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email','public_profile'];; // Optional permissions
$loginUrl = $helper->getLoginUrl(URL_ROOT.'fb-callback.html', $permissions);

?>

<div class="cf">
	<div class="content-login cf">
		<div class="wrapper-form-login">
			<div class="row-register cf ">
				<p class="title-login " ><?php echo FSText::_('Đăng ký thành viên'); ?> </p>
			</div>
			<form action="<?php echo FSRoute::_("index.php?module=users&view=users&task=login&Itemid=11") ?>" name="register_form" class="register_form" method="post" onsubmit="javascript: return checkFormsubmit();">
				<div class="message"></div>
				<div class="form-login">
					<div class="row-register cf ">
						<div class='value '>
							<input required placeholder="<?php echo FSText::_('Tài khoản đăng nhập'); ?>" type="text" name="username" id="username1"  class='txtinput  fr txt-login' value=""/>

						</div>

					</div>
					<div class="row-register cf ">                     
						<input required placeholder="<?php echo FSText::_('Số điện thoại'); ?>" type="tel" name="mobilephone" id="mobilephone"  class='txtinput numberCheck fr txt-login' value=""/>
					</div>
					<div class="row-opt cf hidden">
						<div class='value '>
							<input placeholder="<?php echo FSText::_('Nhập 4 số gửi về điện thoại của bạn'); ?>" type="tel" name="pincode" id="pincode"  class='txtinput pincode fr txt-login' value=""/>
							<button id="verify_opt_bt" type="button" onclick="verify_opt();">Đồng ý</button>
						</div>

					</div>

					<div class="row-register cf ">
						<div class='value fr'>
							<input required placeholder="<?php echo FSText::_('Nhập mật khẩu'); ?>" type="password" name="password" id="password"  class='txtinput fr txt-login' autocomplete="off" />
						</div>
					</div>

					<div class="row-register cf ">
						<div class='value fr'>
							<input placeholder="<?php echo FSText::_('Họ và tên'); ?>" type="text" name="full_name"   class='txtinput fr txt-login' value=""/>
						</div>
					</div>

					<div class="row-register cf ">
						<div class='value fr'>
							<input placeholder="<?php echo FSText::_('Email'); ?>" type="text" name="email" class='txtinput fr txt-login' value=""/>
						</div>
					</div>

					<div class="row-register cf ">
						<div class='value fr'>
							<select id="game" name="betting_game" class='txtinput txt-login' required">   
								<option value="">Chọn tài khoản cá cược</option>
								<?php foreach ($game as $item) { ?>
									<option value="<?php echo $item -> id ?>"><?php echo $item -> name ?></option>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="row-register cf ">
						<div class='value fr'>
							<select id="point_discount" name="money" class='txtinput txt-login' required>
							</select>
						</div>
					</div>
				</div>
				<div class="wrapper-form-2">
					<div class="row-register cf ">
						<div class=" wrapper-bt-register">
							<input type="submit" class='submitbt login' name="submitbt" value = "<?php echo FSText::_('Đăng ký'); ?>"   />
						</div>
					</div>
					<div class="row-register cf ">
						<div class="note-other">
							<?php global  $config;?>
							<?php echo $config['term_register'];  ?>
						</div>
					</div>
				</div>

				<input type="hidden" name = "is_agency" id=" is_agency" value ="0" />
				<input type="hidden" name = "phone_verify" id="phone_verify" value = "" />
				<input type="hidden" name = "module" value = "users" />
				<input type="hidden" name = "view" value = "users" />
				<input type="hidden" name = "Itemid" value = "<?php echo $Itemid; ?>" />
				<input type="hidden" name = "task" value = "register_save" />
				<?php if(isset($_COOKIE['code_gt'] )){ ?>
					<input type="hidden" name = "code_gt_for_user" value = "<?php echo $_COOKIE['code_gt'] ; ?>" />
				<?php } ?>


			</form>
		</div>

	</div>
</div>

