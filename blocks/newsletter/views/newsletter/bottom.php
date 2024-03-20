<?php 
 global $tmpl;
 $tmpl -> addStylesheet('newsletter','blocks/newsletter/assets/css');
 $tmpl -> addScript('newsletter.min','blocks/newsletter/assets/js');
 ?>
 <div class="footer_title"><?php echo FSText::_('Đăng ký nhận khuyến mãi'); ?></div>
 <div class="newsletter_summary">Chỉ cần nhập email và nhấn đăng ký, chúng tôi sẽ gửi thông tin khuyến mãi và báo giá đến bạn!</div>
 
<form id="newsletter_form" method="post" name="newletter_form" action="<?php echo URL_ROOT.'newsletter.html'; ?>" onsubmit="javascript: return check_newletter_form();" >
	
    <input type="text" name="email" id="nl_email" value="" class="txt-input"  placeholder="Email của bạn" />
    <button type="submit">Đăng ký</button>
    <input type="hidden" name='return' value="<?php echo base64_encode($_SERVER['REQUEST_URI']);?>"  />
</form>