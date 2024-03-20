<form id="newsletter_form" method="post" name="newletter_form" action="<?php echo URL_ROOT.'newsletter.html'; ?>" onsubmit="javascript: return check_newletter_form();" >
    <strong class="label"><?php echo FSText::_('NEWsLetter')?></strong>
    <input type="text" id="nl_name" name="name" value="<?php echo FSText::_('Enter your name');?>" class="txt-input" onfocus="this.value=''" onblur="if(this.value=='') this.value='<?php echo FSText::_('Enter your name');?>'" />
    <input type="text" name="email" id="nl_email" value="<?php echo FSText::_('Enter your email');?>" class="txt-input" onfocus="this.value=''" onblur="if(this.value=='') this.value='<?php echo FSText::_('Enter your email');?>'" />
    <input type="submit" name="submit" value="<?php echo FSText::_('Submit')?>" class="button-sub" />
    <input type="hidden" name='return' value="<?php echo base64_encode($_SERVER['REQUEST_URI']);?>"  />
</form>