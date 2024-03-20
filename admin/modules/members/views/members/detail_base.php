<table cellspacing="1" class="admintable">

	<!-- TemplateHelper::dt_edit_text(FSText :: _('Tên đăng nhập / Email'),'username',@$data -> username);    -->

	<div class="form-group">
		<label class="col-md-2 col-xs-12 control-label">Tên đăng nhập / Email</label>
		<div class="col-md-10 col-xs-12">
			<input type="text" class="form-control" name="username" id="username" value="<?php echo @$data-> username; ?>" size="60"></div></div>

			<?php
// TemplateHelper::dt_edit_text(FSText :: _('Điểm đạt'),'point',@$data -> point); 
			TemplateHelper::dt_edit_text(FSText :: _('Họ tên'),'full_name',@$data -> full_name);
			TemplateHelper::dt_edit_text(FSText :: _('Số điện thoại'),'telephone',@$data -> telephone);
			TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email);
			?>
			<div class="form-group">
				<label class="col-md-2 col-xs-12 control-label">Ngày sinh</label>
				<div class="col-md-10 col-xs-12">
					<span><?php echo FSText::_("Day"); ?></span>
					<select name="birth_day" class="form-control">
						<?php 
						$day = date('d',strtotime(@$data->birthday));
						$month = date('m',strtotime(@$data->birthday));
						$year = date('Y',strtotime(@$data->birthday));
						?>
						<?php for($i = 1 ; $i < 32 ; $i ++ ) {?>
							<?php $check = ($i == $day) ? "selected='selected'": ""; ?>
							<option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
						<?php }?>
					</select>	
					<span><?php echo FSText::_("Month"); ?></span>		
					<select name="birth_month" class="form-control">
						<?php for($i = 1 ; $i < 13 ; $i ++ ) {?>
							<?php $check = ($i == $month) ? "selected='selected'": ""; ?>
							<option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
						<?php }?>
					</select>	

					<span><?php echo FSText::_("Year"); ?></span>		
					<select name="birth_year" class="form-control">
						<?php $current_year = date("Y");?>
						<?php for($i = $current_year ; $i > 1900 ; $i -- ) {?>
							<?php $check = ($i == $year) ? "selected='selected'": ""; ?>
							<option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
						<?php }?>
					</select>	

				</div>
			</div>

			<?php 

			$sex_status = array('male'=>'Nam','female'=>'Nữ');
			TemplateHelper::dt_edit_selectbox('Giới tính','sex',@$data -> sex,0,$sex_status,'id', 'name',$size = 1,0);
			TemplateHelper::dt_edit_text(FSText :: _('CMND'),'identity_card',@$data -> identity_card);
			TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),50,50,'Kích cỡ ảnh: 400x400');

			TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ'),'address',@$data -> address);
// TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ nhận hàng'),'address_receipt',@$data -> address_receipt);  
			TemplateHelper::dt_edit_selectbox(FSText::_('Tỉnh / Thành phố'),'city_id',@$data -> city_id,0,$cities,$field_value = 'id', $field_label='name',$size = 1,0);
// TemplateHelper::dt_edit_selectbox(FSText::_('Quận / Huyện'),'district_id',@$data -> district_id,0,$districts,$field_value = 'id', $field_label='name',$size = 1,0);
// TemplateHelper::dt_edit_selectbox(FSText::_('Xã / Phường'),'ward_id',@$data -> ward_id,0,$wards,$field_value = 'id', $field_label='name',$size = 1,0);
// TemplateHelper::dt_checkbox(FSText::_('Nam'),'published',@$data -> published,1);
// TemplateHelper::dt_edit_text(FSText :: _(''),'fullname',@$data -> fullname);  
			TemplateHelper::dt_notedit_text(FSText :: _('Điểm'),'show_point',@$data -> point);  

			TemplateHelper::dt_edit_selectbox(FSText::_('Hạng thành viên'),'level',@$data -> level,0,$arr_level,$field_value = 'id', $field_label='name',$size = 1,0);


// TemplateHelper::dt_edit_text(FSText :: _('Icon (SVG)'),'icon',@$data -> icon);
    //TemplateHelper::dt_edit_text(FSText :: _('Cat'),'category_id',@$data -> category_id);
//	TemplateHelper::dt_edit_selectbox(FSText::_('City'),'city_id',@$data -> city_id,0,$cities,$field_value = 'id', $field_label='name',$size = 10,0);
// TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),50,50,'Kích cỡ ảnh: 400x400');
// TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='name',$size = 1,0);
			TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
			TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
// TemplateHelper::dt_edit_text(FSText :: _('Link'),'link',@$data -> link);  
// TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'summary',@$data -> summary,'',100,5,0);
// TemplateHelper::dt_edit_text(FSText :: _('Mô tả ( khi lật)'),'summary_hover',@$data -> summary_hover,'',100,5,0);
// $this -> dt_form_end(@$data);

			?>

			<tr>
				<td class="label1"><span><?php echo FSText::_('Sửa password')?></span></td>
				<td class="value1">
					<input type="radio" name="edit_pass" id="edit_pass1" class='edit_pass' value="1" /> <span class="edit_pass" <?php if(!@$data-> id) echo 'checked="checked"'; ?>>Có</span>
					<input type="radio" name="edit_pass" id="edit_pass0" class='edit_pass'  value="0" <?php if(@$data-> id) echo 'checked="checked"'; ?>/> <span class="edit_pass">Không</span>
				</td>
			</tr>
			<tr class='password_area <?php echo @$data -> id?"hide":""?>' >
				<td class='label1'><font>*</font><?php echo FSText::_("Password")?></td>
				<td class='value1'>
					<input type="password" name="password1" id="password" />
				</td>
			</tr>
			<tr class='password_area <?php echo @$data -> id?"hide":""?>'>
				<td class='label1'><font>*</font><?php echo FSText::_("Re-Password")?></td>
				<td class='value1'>
					<input type="password" name="re-password1" id="re-password" />
				</td>
			</tr>
		</table>

		<style>
		.edit_pass {
			display: inline-block;
			float: left;width: 50px;
			display: block !important;
		}
	</style>


	<script  type="text/javascript" language="javascript">
		$(function(){
		// $("#city_id").change(function(){
		// 	// alert('22');
		// 	$.ajax({url: "index.php?module=members&task=district&raw=1",
		// 		data: {cid: $(this).val()},
		// 		dataType: "text",
		// 		success: function(text) {
		// 			// alert(text);
		// 			if(text == '')
		// 				return;
		// 			j = eval("(" + text + ")");
		// 			var options = '';
		// 			for (var i = 0; i < j.length; i++) {
		// 				options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
		// 			}
		// 			$('#district_id').html(options);
		// 			elemnent_fisrt = $('#district_id option:first').val();
		// 		}
		// 	});

		// 	$.ajax({url: "index.php?module=members&task=ward2&raw=1",
		// 		data: {cid: $(this).val()},
		// 		dataType: "text",
		// 		success: function(text) {
		// 			// alert(text);
		// 			if(text == '')
		// 				return;
		// 			j = eval("(" + text + ")");
		// 			var options = '';
		// 			for (var i = 0; i < j.length; i++) {
		// 				options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
		// 			}
		// 			$('#ward_id').html(options);
		// 			elemnent_fisrt = $('#ward_id option:first').val();
		// 		}
		// 	});
		// });

		// $("#district_id").change(function(){
		// 	// alert('22');
		// 	$.ajax({url: "index.php?module=members&task=ward&raw=1",
		// 		data: {cid: $(this).val()},
		// 		dataType: "text",
		// 		success: function(text) {
		// 			// alert(text);
		// 			if(text == '')
		// 				return;
		// 			j = eval("(" + text + ")");
		// 			var options = '';
		// 			for (var i = 0; i < j.length; i++) {
		// 				options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
		// 			}
		// 			$('#ward_id').html(options);
		// 			elemnent_fisrt = $('#ward_id option:first').val();
		// 		}
		// 	});
		// });


		// $('.password_area').hide();
		$('#edit_pass0').click(function(){
			$('.password_area').addClass('hide');
		});
		$('#edit_pass1').click(function(){
			$('.password_area').removeClass('hide');
		});

	})
</script>