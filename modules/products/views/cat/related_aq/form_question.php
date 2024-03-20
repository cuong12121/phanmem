<?php
	global $tmpl;
	$tmpl -> addStylesheet('form_question','blocks/aq/assets/css');
	$tmpl -> addScript('form_question','blocks/aq/assets/js');
	$page = FSInput::get('page');
    $Itemid = 7;
	$tmpl -> addScript('form');
?>	
	
<div class="all-form-question hide">
	 	<div class="home_title">
	     	<span><?php echo FSText::_('Gửi câu hỏi'); ?> </span>
	    </div>
	
		<div id="smart-green-demo">
			<!-- <div class='send_request_note'><?php //echo $cf_send_request_note; ?></div> -->
			<form action="#" method="post" name="aks" enctype="multipart/form-data" class="formask smart-green" onsubmit="javascript: return  check_form_question();" >
				<div class="wrap_pos">
					<div class="label">
						<input id="asker" type="text" name="asker" placeholder="<?php echo FSText::_('Họ và tên'); ?>" >
					</div>
					<div class="label">
						<input id="phone" type="text" name="phone" placeholder="<?php echo FSText::_('Điện thoại'); ?>" >
					</div>
					<div class="label">
						<input id="email" type="text" name="email" placeholder="Email" >
					</div>

					<input type="hidden" value="<?php echo $cat-> category_aq?$cat-> category_aq:13;?>" name="category_id">
						
					
					<div class="label">
						<input id="title" type="text" name="title" placeholder="<?php echo FSText::_('Tiêu đề'); ?>" >
					</div>
					
				</div>	
					<div class="clear" ></div>
					<div class="label2">
						<textarea width= "100%" id="message" name="message" cols="30" rows="8" placeholder="<?php echo FSText::_('Nội dung'); ?>"></textarea>
					</div>
					<div class="clear" ></div>
					<div class="button_area">
						<button type="submitbt" class="submit_bt"><?php echo FSText::_('Gửi'); ?></button>							 
					</div>
			
				<input type="hidden" name="module" value="aq">
				<input type="hidden" name="task" value="save">
				<input type="hidden" name="view" value="aq">
				<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>">
			</form>
		</div>
</div>
