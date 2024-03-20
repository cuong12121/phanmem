<link rel="stylesheet" type="text/css" media="screen" href="<?php echo URL_ROOT.'modules/users/assets/css/users_edit.css'; ?>" />
<h2 class='head_content'>
	Thiết lập tài khoản
</h2>
<div class="tab_content_inner">
	<div class="title_content">Thông tin cơ bản</div>
	<form id="form-user-edit" action="<?php echo FSRoute::_("index.php?module=users&task=edit_save&Itemid=40"); ?>" method="post" name="form-user-edit">
		<div class="fieldset_item_row">
		    <div class="form_name">Email</div>
		    <div class="value">
		    	<input class="txtinput" type="text" name="email" id="email" value="<?php echo $data->email;?>" />
		    </div>
		 </div>
		 <div class="fieldset_item_row">
		    <div class="form_name">Họ &amp; tên</div>
		    <div class="value">
		    	<input class="txtinput" type="text" name="full_name" id="full_name" value="<?php echo $data->full_name;?>" />
		 	</div>
		 </div>
		 <div class="fieldset_item_row">
		    <div class="form_name">Tỉnh thành</div>
		    <div class="value">
		    	<input class="txtinput" type="text" name="city" id="city" value="<?php echo $data->city;?>" />
		    </div>
		  </div>
		<div class="fieldset_item_row">
	    	<div class="form_name">Giới tính</div>
	   		<div class="value">
		    	<input class="txtinput" type="text" name="gender" id="gender" value="<?php echo $data->gender;?>" />
		    </div>
	  	</div>
		<div class="fieldset_item_row">
	    	<div class="form_name">Số điện thoại</div>
	   		 <div class="value">
	   		 	<input class="txtinput" type="text" name="telephone" id="telephone" value="<?php echo $data->telephone;?>" />
	   		 </div>
	  	</div>
		<div class="fieldset_item_row">
	    	<div class="form_name">Ngày sinh</div>
			<div class="value">
		    	<input class="txtinput" type="text" name="v_birthday" id="v_birthday" value="<?php echo $data->v_birthday;?>" />
		    </div>
	 	</div>
		<div class="fieldset_item_row">
	  		<div class="form_name">&nbsp;</div>
		  	<div class="value">
		    	<input class="button-submit-edit submitbt btn " name="submit" type="submit" value="Lưu thay đổi"  />
		        <input class="button-reset-edit submitbt btn " name="reset" type="reset" value="Hủy"   />
		    </div>
	  </div>
	
	</form>
</div>