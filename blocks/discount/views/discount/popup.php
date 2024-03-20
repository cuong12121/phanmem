<?php 
 global $tmpl;
 $tmpl -> addStylesheet('popup','blocks/discount/assets/css');
 $tmpl -> addScript('popup','blocks/discount/assets/js');
 $Itemid = FSInput::get('Itemid',1,'int');
 ?>
<div class='block_content discount_popup_content'>
	<div class='label' id='discount_popup_content_label'><span>Nhận Voucher</span></div>
	<?php if($Itemid == 1){?>
	<div class='discount_popup_content_inner discount_popup_open' id='discount_popup_content_inner' style="display: block;">
	<?php } else {?>
	<div class='discount_popup_content_inner discount_popup_close' id='discount_popup_content_inner' style="display: none;">
	<?php }?>
			<div class='discount_description_label'>Đăng ký nhận Voucher</div>
			<div class='discount_description_inner_wrapper'>
				<div class='discount_description_inner'>
					<div class='discount_description'><?php echo $discount -> description?></div>
					<form id="discount_form" method="post" name="newletter_form" action="<?php echo FSRoute::_('index.php?module=discount&task=save'); ?>" onsubmit="javascript: return check_discount_form_popup();" >
					    <input type="text" name="email" id="dc_email_popup" value="<?php echo FSText::_('Enter your email');?>" class="txt-input" onfocus="this.value=''" onblur="if(this.value=='') this.value='<?php echo FSText::_('Enter your email');?>'" />
					    <div>
						    <input type="submit" name="female" value="<?php echo FSText::_('Dành cho Nữ')?>" class="button-sub button bt-select"  id='bt-female_popup'/>
						    <input type="submit" name="male" value="<?php echo FSText::_('Dành cho Nam')?>" class="button-sub button" id='bt-male_popup'/>
						 </div>
						 <div class='note'>
						 Thông tin của bạn sẽ được giữ kín tuyệt đối, và bạn có thể hủy đăng ký bất cứ lúc nào.
						 </div>
					    <input type="hidden" name='return' value="<?php echo base64_encode($_SERVER['REQUEST_URI']);?>"  />
					    <input type="hidden" name='discount_id' value="<?php echo $discount -> id;?>"  />
					</form>
				</div>	
			</div>	
	</div>	
</div>