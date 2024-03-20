<?php
	global $tmpl;
	$tmpl -> addStylesheet('form_question','modules/aq/assets/css');
	$tmpl -> addScript('form_question','modules/aq/assets/js');
	$page = FSInput::get('page');
    $Itemid = 7;
	$tmpl -> addScript('form');
?>	
	<div class="aq_home wapper-page  wapper-page-cat">
		<div class="page_head">
		 	<h1 class="home_title">
		     	<span><?php echo FSText::_('Gửi câu hỏi'); ?> </span>
		    </h1>
	    </div>
		<div id="smart-green-demo">
			<!-- <div class='send_request_note'><?php //echo $cf_send_request_note; ?></div> -->
			<form action="#" method="post" name="aks" enctype="multipart/form-data" class="formask smart-green" onsubmit="javascript: return  check_form_question();" >
				
					<div class="label">
						<input id="asker" type="text" name="asker" placeholder="<?php echo FSText::_('Họ và tên'); ?>" >
					</div>
					<div class="label">
						<input id="phone" type="text" name="phone" placeholder="<?php echo FSText::_('Điện thoại'); ?>" >
					</div>
					<div class="label">
						<input id="email" type="text" name="email" placeholder="Email" >
					</div>

					<div class="label">
						<select name="category_id" id = "category_id">
                 		<option value=""  ><?php echo FSText::_('Chuyên mục'); ?></option>
                                    <?php foreach($categories as $item){?>
                                        <option value="<?php echo $item->id; ?>"  ><?php echo $item->name ; ?></option>
                                    <?php } ?>
                                </select>
					</div>
					<div class="label">
						<input id="title" type="text" name="title" placeholder="<?php echo FSText::_('Tiêu đề'); ?>" >
					</div>
					<div class="label">
						<textarea id="message" name="message" cols="30" rows="8" placeholder="<?php echo FSText::_('Nội dung'); ?>"></textarea>
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
