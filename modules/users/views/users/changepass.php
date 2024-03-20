<?php
global $tmpl;
$tmpl -> addStylesheet("users_edit","modules/users/assets/css");
$tmpl -> addScript('form');
$tmpl -> addScript('users_changepass','modules/users/assets/js');
?>

<?php include 'menu_user.php'; ?>

<div id="register-form" class ="user_content " >
	<h2 class="head_content">Đổi mật khẩu</h2>
	<div class="frame_large_body">
		<!--   FRAME COLOR        -->
		<div class='user_content_inner user_register' >
			<div class=' tab_content_inner'>
				<div class=''>

					<!--  CONTENT IN FRAME      -->

					<form action="#" name="frm_repassword_gh" method="post" id="frm_repassword_gh">
						<div class="fieldset_item_row cls cls">
							<div class="form_name"><?php echo FSText::_("Mật khẩu mới"); ?></div>
							<div class="value">
								<input class="txtinput" type="password" name="password" id="password" value="" />
							</div>
						</div>
						<div class="fieldset_item_row cls change_pass">
							<div class="form_name"><?php echo FSText::_("Nhập lại"); ?></div>
							<div class="value">
								<input class="txtinput" type="password" name="re-password" id="re-password" value="" />
							</div>
						</div>
						<div class="fieldset_item_row cls change_pass">
							<div class="form_name"><?php echo FSText::_("Mật khẩu cũ"); ?></div>
							<div class="value">
								<input class="txtinput" type="password" name="verify_old_password" id="verify_old_password" value="" />
							</div>
						</div>
						<div class="fieldset_item_row cls">
							<div class="form_name">&nbsp;</div>
							<div class="value">
								<input class="button-submit-edit submitbt btn" id="submitbt" name="submit" type="submit" value="<?php echo FSText::_("Cập nhật"); ?>"  />
							</div>
						</div>
						<input type="hidden" name = "module" value = "users" />
						<input type="hidden" name = "task" value = "edit_save_changepass" />
						<input type="hidden" name = "Itemid" value = "<?php echo FSInput::get('Itemid');?>" />
					</form>
					<!--	FORM			-->
				</div>
			</div>
			<div class='frame_color_b'>
				<div class='frame_color_b_r'>&nbsp; </div>
			</div>
		</div>
		<!--   end FRAME COLOR        -->

		<!--   end SUBMIT REGISTER        -->

	</div>
	<div class="frame_large_footer">
		<div class="frame_large_footer_l">&nbsp;</div>
		<div class="frame_large_footer_r">&nbsp;</div>
	</div>
</div>    

