<?php 
 global $tmpl;
 $tmpl -> addStylesheet('sex','blocks/discount/assets/css');
 $tmpl -> addScript('discount','blocks/discount/assets/js');
 ?>
<div class='block_content discount_content'>
	<div class='discount_description'><?php echo $discount -> description?></div>
	<form id="discount_form" method="post" name="newletter_form" action="<?php echo FSRoute::_('index.php?module=discount&task=save'); ?>" onsubmit="javascript: return check_discount_form();" >
	    <input type="text" name="email" id="dc_email" value="<?php echo FSText::_('Enter your email');?>" class="txt-input" onfocus="this.value=''" onblur="if(this.value=='') this.value='<?php echo FSText::_('Enter your email');?>'" />
	    <input type="submit" name="female" value="<?php echo FSText::_('Nữ')?>" class="button-sub button bt-select"  id='bt-female'/>
	    <input type="submit" name="male" value="<?php echo FSText::_('Nam')?>" class="button-sub button" id='bt-male'/>
	    <input type="hidden" name='return' value="<?php echo base64_encode($_SERVER['REQUEST_URI']);?>"  />
	    <input type="hidden" name='discount_id' value="<?php echo $discount -> id;?>"  />
	</form>
</div>