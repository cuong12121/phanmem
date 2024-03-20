<table cellspacing="1" class="admintable">
<?php
	
	TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_text(FSText :: _('iframe '),'file_flash',@$data -> file_flash,'',100,3);
	TemplateHelper::dt_edit_image(FSText :: _('Ảnh'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),200,150,'Kích cỡ ảnh: 700x417');
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	
	$this -> dt_form_end(@$data,1,0);

?>

</table>
<script type="text/javascript" >
	$(function() {
		$( "#published_date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
		$( "#published_date").change(function() {
			document.formSearch.submit();
		});
	});
</script>	
	