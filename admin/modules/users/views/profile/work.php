<?php 
	TemplateHelper::dt_checkbox(FSText::_('Trạng thái'),'work_status',@$data -> work_status,1,$array_value = array(1 => 'Đang làm việc', 0 => 'Đã nghỉ' ));
	TemplateHelper::dt_edit_text(FSText :: _('Phòng ban'),'department',@$data -> department,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Vị trí'),'position',@$data -> position,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Chức vụ'),'regency',@$data -> regency,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Ngày vào'),'day_in',date('d-m-Y',strtotime(@$data -> day_in)),'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Ngày vào chính thức'),'day_in_main',date('d-m-Y',strtotime(@$data -> day_in_main)),'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Nơi làm việc'),'workplace',@$data -> workplace,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Ngạch lương'),'glone',@$data -> glone,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Cấp bậc'),'rank',@$data -> rank,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Nhóm người dùng'),'user_group_name',@$data -> user_group_name,'',60,5);
?>

<script  type="text/javascript" language="javascript">
	$(function() {
		$("#day_in").datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
		$("#day_in_main").datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
	});
</script>