<table cellspacing="1" class="admintable">
<?php 
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_text(FSText :: _('Tên ngắn'),'sort',@$data -> sort,'Combo giảm giá');
	
	$sub_time = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','started_hour',@$data -> started_time?date('H:i',strtotime(@$data -> started_time)):'','','5',1);
	TemplateHelper::dt_edit_text(FSText :: _('Thời gian bắt đầu'),'started_date',@$data -> started_time?date('d-m-Y',strtotime(@$data -> started_time)):'','','12',1,0,'Nhập dạng <strong>d-m-Y H:i</strong>.',$sub_time);
		
	$sub_time = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','finished_hour',@$data -> finished_time?date('H:i',strtotime(@$data -> finished_time)):'','','5',1);
	TemplateHelper::dt_edit_text(FSText :: _('Thời gian kết thúc'),'finished_date',@$data -> finished_time?date('d-m-Y',strtotime(@$data -> finished_time)):'','','12',1,0,'Nhập dạng <strong>d-m-Y H:i</strong>.',$sub_time);
	
	
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9,0);
	TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'description',@$data -> description,'',650,450,1);
?>
</table>
<input type="hidden" name="type" value="5" />


<script  type="text/javascript" language="javascript">
	$(function() {
		$( "#started_date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
		$( "#finished_date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
	});
</script>
