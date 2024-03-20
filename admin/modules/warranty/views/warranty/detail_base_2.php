<table cellspacing="1" class="admintable">
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Tên khách hàng</label>
		<div class="col-md-10 col-xs-12">
			<?php echo $data->name_guest ?>
		</div>
	</div>
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Số điện thoại khách</label>
		<div class="col-md-10 col-xs-12">
			<?php echo $data->phone_guest ?>
		</div>
	</div>
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Địa chỉ khách</label>
		<div class="col-md-10 col-xs-12">
			<?php echo $data->address_guest ?>
		</div>
	</div>
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Mô tả sản phẩm lỗi gì</label>
		<div class="col-md-10 col-xs-12">
			<?php echo $data->note ?>
		</div>
	</div>
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Link hình ảnh / Video</label>
		<div class="col-md-10 col-xs-12">
			<?php echo $data->link_video ?>
		</div>
	</div>
<?php
	TemplateHelper::dt_edit_text(FSText :: _('Người thực hiện'),'name',@$data -> name,'',100,1,0);
	TemplateHelper::dt_edit_selectbox('Bộ phận chịu tránh nhiệm(Chịu phí)','room_id',@$data -> room_id,'',$array_group,$field_value = 'id', $field_label='name',$size = 1,0,1);

	TemplateHelper::dt_edit_selectbox('Trạng thái','status',@$data -> status,'',$array_status,$field_value = '', $field_label='',$size = 1,0,0);

	TemplateHelper::dt_edit_text(FSText :: _('Lý do không hoàn thành'),'note2',@$data -> note2,'',100,5,1);
	TemplateHelper::dt_edit_text(FSText :: _('Mã chuyển hoàn cho khách'),'code_return',@$data -> code_return,'',100,1,0);
?>
</table>

<script  type="text/javascript" language="javascript">
    $(function() {
        $( "#date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    });
</script>