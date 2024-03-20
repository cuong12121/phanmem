<?php 
 global $tmpl,$config;
 $tmpl -> addStylesheet('discount','blocks/discount/assets/css');
 ?>
<div class='block_content discount_content'>
	<div class='discount_title'><?php echo $config['recipient_email']?></div>
	<form id="discount_form" method="post" name="newletter_form" action="<?php echo FSRoute::_('index.php?module=discount&task=save'); ?>" onsubmit="javascript: return check_discount_form();" >
	    <input type="text" name="email" id="dc_email" value="<?php echo FSText::_('Nhập email...');?>" class="txt-input pull-left" onfocus="this.value=''" onblur="if(this.value=='') this.value='<?php echo FSText::_('Enter your email');?>'" />
	    <input type="submit" name="submit" value="<?php echo FSText::_('Đăng ký')?>" class="button-sub button pull-left" />
	    <input type="hidden" name='return' value="<?php echo base64_encode($_SERVER['REQUEST_URI']);?>"  />
	    <input type="hidden" name='discount_id' value="<?php echo $discount -> id;?>"  />
	</form>
	<div class='discount_description'><?php echo $discount -> description?></div>
</div>