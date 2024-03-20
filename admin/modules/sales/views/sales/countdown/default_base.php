<table cellspacing="1" class="admintable">
<?php 
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	// TemplateHelper::dt_edit_text(FSText :: _('Tên ngắn'),'sort',@$data -> sort,'Giờ vàng giá sốc');

	// TemplateHelper::dt_edit_text(FSText :: _('Số lượng bán ra'),'total_item',@$data -> total_item);

	TemplateHelper::dt_edit_text(FSText :: _('Mã màu'),'code_color',@$data -> code_color);
	TemplateHelper::dt_edit_text(FSText :: _('Số sản phẩm xem trước'),'preview_count_item',@$data -> preview_count_item);


	
	TemplateHelper::dt_edit_image(FSText :: _('Ảnh title'),'image',str_replace('/original/','/original/',URL_ROOT.@$data->image),100,100,'Kích cỡ ảnh tùy nhập lên');

	TemplateHelper::dt_edit_image(FSText :: _('Ảnh banner chính - Ưu tiên mới phải nhập'),'image2',str_replace('/original/','/original/',URL_ROOT.@$data->image2),200,100,'Kích cỡ ảnh tùy nhập lên');

	$sub_time = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','started_hour',@$data -> started_time?date('H:i',strtotime(@$data -> started_time)):'','','5',1);
	TemplateHelper::dt_edit_text(FSText :: _('Thời gian bắt đầu'),'started_date',@$data -> started_time?date('d-m-Y',strtotime(@$data -> started_time)):'','','12',1,0,'Nhập dạng <strong>d-m-Y H:i</strong>.',$sub_time);
		
	$sub_time = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','finished_hour',@$data -> finished_time?date('H:i',strtotime(@$data -> finished_time)):'','','5',1);
	TemplateHelper::dt_edit_text(FSText :: _('Thời gian kết thúc'),'finished_date',@$data -> finished_time?date('d-m-Y',strtotime(@$data -> finished_time)):'','','12',1,0,'Nhập dạng <strong>d-m-Y H:i</strong>.',$sub_time);
	
	
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	// TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9,0);
	// TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'description',@$data -> description,'',650,450,1);
?>
</table>
<input type="hidden" name="type" value="1" />


<script  type="text/javascript" language="javascript">
	$(function() {
		$( "#started_date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
		$( "#finished_date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
	});
</script>
