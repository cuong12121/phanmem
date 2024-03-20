<table cellspacing="1" class="admintable">
<?php 

	TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	$sub_time_start = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','published_hour_start',@$data -> date_start?date('H:i',strtotime(@$data -> date_start)):'','','5',1);
	TemplateHelper::dt_edit_text(FSText :: _('Ngày bắt đầu'),'date_start',@$data -> date_start?date('d-m-Y',strtotime(@$data -> date_start)):'','','12',1,0,'Nhập dạng <strong>dd-mm-YYYY HH:mm</strong>.',$sub_time_start);
	$sub_time_end = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','published_hour_end',@$data -> date_end?date('H:i',strtotime(@$data -> date_end)):'','','5',1);
	TemplateHelper::dt_edit_text(FSText :: _('Ngày hết hạn'),'date_end',@$data -> date_end?date('d-m-Y',strtotime(@$data -> date_end)):'','','12',1,0,'Nhập dạng <strong>dd-mm-YYYY HH:mm</strong>.',$sub_time_end);
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image));
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
//	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',60,3,0);
	TemplateHelper::dt_edit_text(FSText :: _('Content'),'content',@$data -> content,'',650,450,1);
	TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,2);
	TemplateHelper::dt_sepa();
	TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1);
	TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1);
	TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,9);
?>
</table>

<script  type="text/javascript" language="javascript">
$(function() {
	$( "#date_end" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
	$( "#date_end").change(function() {
		document.formSearch.submit();
	});
	$( "#date_start" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
	$( "#date_start").change(function() {
		document.formSearch.submit();
	});
});
</script>
