
<?php 
	TemplateHelper::dt_edit_text(FSText :: _('Họ tên'),'fullname',@$data -> fullname,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Mã NV/ Mã chấm công'),'code',@$data -> code,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Ngày sinh'),'birthday',date('d-m-Y',strtotime(@$data -> birthday)),'',60,1,0);
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),100,100,'Kích cỡ ảnh: 700x700');
	TemplateHelper::dt_checkbox(FSText::_('Giới tính'),'sex',@$data -> sex,1,$array_value = array(1 => 'Nam', 0 => 'Nữ' ));
	TemplateHelper::dt_checkbox(FSText::_('Tình trạng hôn nhân'),'marital_status',@$data -> marital_status,1,$array_value = array(1 => 'Độc thân', 0 => 'Đã có gia đình' ));
	TemplateHelper::dt_edit_text(FSText :: _('Quốc tịch'),'nationality',@$data -> nationality,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Điện thoại'),'phone',@$data -> phone,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Mạng xã hội'),'socia',@$data -> socia,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Dân tộc'),'ethnic',@$data -> ethnic,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Tôn giáo'),'religion',@$data -> religion,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('CMT/Căn cước/Hộ chiếu'),'people_id',@$data -> people_id,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Ngày cấp, Nơi cấp'),'people_id_date_add',@$data -> people_id_date_add,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Nơi sinh'),'place_of_birth',@$data -> place_of_birth,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Nguyên quán'),'domicile',@$data -> domicile,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('[Chỗ ở hiện nay] Địa chỉ'),'address',@$data -> address,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Mã số thuế cá nhân'),'tax_code',@$data -> tax_code,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('TK ngân hàng'),'bank',@$data -> bank,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Trình độ phổ thông'),'high_school_level',@$data -> high_school_level,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Trình độ học vấn cao nhất'),'high_school_level_top',@$data -> high_school_level_top,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Thông tin gia đình & người phụ thuộc'),'relative',@$data -> relative,'',60,5);
	TemplateHelper::dt_edit_text(FSText :: _('Trình độ học vấn'),'education',@$data -> education,'',60,5);

	TemplateHelper::dt_edit_text(FSText :: _('Kinh nghiệm làm việc'),'experience',@$data -> experience,'',60,5);
	TemplateHelper::dt_edit_text(FSText :: _('Lịch sử đảng viên'),'party_member',@$data -> party_member,'',60,5);

	TemplateHelper::dt_edit_image(FSText :: _('Mặt trước căn cước'),'image_t_peopel_id',str_replace('/original/','/resized/',URL_ROOT.@$data->image_t_peopel_id),100,100);
	TemplateHelper::dt_edit_image(FSText :: _('Mặt sau căn cước'),'image_s_peopel_id',str_replace('/original/','/resized/',URL_ROOT.@$data->image_s_peopel_id),100,100);
?>

<script  type="text/javascript" language="javascript">
	$(function() {
		$( "#birthday" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
	
	});
</script>