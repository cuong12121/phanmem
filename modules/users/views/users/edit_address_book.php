<div class='title_add_2'>
	Sửa địa chỉ
</div>
<div class="add_address add_address_full clearfix">
	<form id="form-add-address" action="<?php echo FSRoute::_("index.php?module=users&task=edit_address_save&Itemid=40"); ?>" method="post" name="form-add-address">
		<div class="fieldset_item_row cls">
			<div class="form_name">Họ tên</div>
			<div class="value">
				<input class="txtinput" type="text" name="full_name" id="full_name" value="<?php echo $address-> full_name; ?>" />
			</div>
		</div>
		<div class="fieldset_item_row cls">
			<div class="form_name">Số điện thoại</div>
			<div class="value">
				<input class="txtinput" type="text" name="telephone" id="telephone" value="<?php echo $address-> telephone; ?>" placeholder="Nhập số điện thoại" />
			</div>
		</div>
		<div class="fieldset_item_row cls">
			<?php dt_edit_selectbox(FSText::_('Tỉnh Thành'),'city_id',@$address -> city_id,0,$cities,$field_value = 'id', $field_label='name',$size = 1,0); ?>
		</div>
		<div class="fieldset_item_row cls">
			<?php dt_edit_selectbox(FSText::_('Quận huyện'),'district_id',@$address -> district_id,0,$districts,$field_value = 'id', $field_label='name',$size = 1,0); ?>
		</div>
		<div class="fieldset_item_row cls">
			<?php dt_edit_selectbox(FSText::_('Xã phường'),'ward_id',@$address -> ward_id,0,$wards,$field_value = 'id', $field_label='name',$size = 1,0); ?>
		</div>

		<div class="fieldset_item_row cls">
			<div class="form_name">Địa chỉ</div>
			<div class="value">
				<input class="txtinput" type="text" name="address" id="address" value="<?php echo $address-> address; ?>" />
			</div>
		</div>
		<div class="fieldset_item_row checkdefault cls">
			<div class="form_name">&nbsp;</div>
			<div class="value">
				<label class="label_default">
				<input class="txtinput" type="checkbox" name="is_default" id="is_default" value="1" <?php if($address-> is_default) echo 'checked'; ?> />
				<span class="fake_checkbox"></span>
				<label for="is_default">Đặt làm địa chỉ mặc định</label>
				</label>
			</div>
		</div>
		<div class="fieldset_item_row save cls">
			<div class="form_name">&nbsp;</div>
			<div class="value">
				<input class="button-submit-add-address submitbt btn" name="submit" type="submit" value="Cập nhật"  />
			</div>
		</div>
		<input type="hidden" name="id" value="<?php echo $address->id?>">
	</form>
</div>

	<script  type="text/javascript" language="javascript">
		$(function(){
			$("#city_id").change(function(){
			// alert('22');
			$.ajax({url: "index.php?module=users&task=district&raw=1",
				data: {cid: $(this).val()},
				dataType: "text",
				success: function(text) {
					// alert(999);
					if(text == '')
						return;
					j = eval("(" + text + ")");
					var options = '';
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
					}
					$('#district_id').html(options);
					elemnent_fisrt = $('#district_id option:first').val();
				}
			});

			$.ajax({url: "index.php?module=users&task=ward2&raw=1",
				data: {cid: $(this).val()},
				dataType: "text",
				success: function(text) {
					// alert(text);
					if(text == '')
						return;
					j = eval("(" + text + ")");
					var options = '';
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
					}
					$('#ward_id').html(options);
					elemnent_fisrt = $('#ward_id option:first').val();
				}
			});
		});

			$("#district_id").change(function(){
			// alert('22');
			$.ajax({url: "index.php?module=users&task=ward&raw=1",
				data: {cid: $(this).val()},
				dataType: "text",
				success: function(text) {
					// alert(text);
					if(text == '')
						return;
					j = eval("(" + text + ")");
					var options = '';
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
					}
					$('#ward_id').html(options);
					elemnent_fisrt = $('#ward_id option:first').val();
				}
			});
		});
		})
	</script>