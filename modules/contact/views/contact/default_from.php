<form method="post" action="#" name="contact" class="form" >
	<div class="contact_table" width="100%">
		<div class="mbl">
			<label><?php echo FSText::_("Họ và tên");?> *</label>
			<input type="text" maxlength="255" placeholder="<?php echo FSText::_("Họ và tên");?>" value="<?php echo $contact_name; ?>" name="contact_name" id="contact_name"  class="txtinput"/>
		</div>
        <div class="mbl">
        	<label><?php echo FSText::_("Điện thoại");?> *</label>
			<input type="text" maxlength="255" placeholder="<?php echo FSText::_("Điện thoại");?>" value="<?php echo $contact_phone; ?>" name="contact_phone" id="contact_phone"  class="txtinput"/>
		</div>
		<div class="mbl">
			<label><?php echo FSText::_("Email");?> *</label>
			<input type="text" maxlength="255" placeholder="<?php echo FSText::_("Email");?>" value="<?php echo $contact_email; ?>" name="contact_email" id="contact_email" class="txtinput"/>
		</div>
        <div class="mbl">
        	<label><?php echo FSText::_("Địa chỉ");?> *</label>
			<input type="text" maxlength="255" placeholder="<?php echo FSText::_("Địa chỉ");?>" value="<?php echo $contact_address; ?>" name="contact_address" id="contact_address" class="txtinput"/>
		</div>
		<div class="mbl">
			<label><?php echo FSText::_("Nội dung");?> *</label>
			<textarea  placeholder="<?php echo FSText::_("Nội dung");?>" rows="8" cols="30" name='message' id='message' ><?php echo $message; ?></textarea>
		</div>
		<div class="mbl">
			<a class="btn" href="javascript: void(0)" id='submitbt'>
				<span><?php echo FSText::_("Gửi liên hệ");?></span>
			</a>
			<!--
            <a class="button" href="javascript: void(0)" id='resetbt'>
				<span>Làm lại</span>
			</a>
            -->
		</div>
	</div>
	<input type="hidden" name="module" value="contact"/>
	<input type="hidden" name="task" value="save"/>
	<input type="hidden" name="view" value="contact"/>
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
</form>
