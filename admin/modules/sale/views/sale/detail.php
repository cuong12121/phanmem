<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));

	$sub_time = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','published_hour_start',@$data -> date_start?date('H:i',strtotime(@$data -> date_start)):'','','5',1);
	TemplateHelper::dt_edit_text(FSText :: _('Thời gian bắt đầu'),'date_start',@$data -> date_start?date('d-m-Y',strtotime(@$data -> date_start)):'','','12',1,0,'Nhập dạng <strong>d-m-Y H:i</strong>.',$sub_time);
		
	$sub_time = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','published_hour_end',@$data -> date_end?date('H:i',strtotime(@$data -> date_end)):'','','5',1);
	TemplateHelper::dt_edit_text(FSText :: _('Thời gian kết date_end'),'date_end',@$data -> date_end?date('d-m-Y',strtotime(@$data -> date_end)):'','','12',1,0,'Nhập dạng <strong>d-m-Y H:i</strong>.',$sub_time);

	// TemplateHelper::dt_edit_text(FSText :: _('Ngày bắt đầu'),'date_start',@$data -> date_start);
	// TemplateHelper::dt_edit_text(FSText :: _('Ngày kết thúc'),'date_end',@$data -> date_end);
	TemplateHelper::dt_edit_text(FSText :: _('Mã giảm giá'),'code',@$data -> code);
	// TemplateHelper::dt_edit_text(FSText :: _('Hạn sử dụng(giờ)'),'expiry_date',@$data -> expiry_date);
	TemplateHelper::dt_edit_text(FSText :: _('Số tiền giảm'),'money_dow',@$data -> money_dow);

	TemplateHelper::dt_edit_selectbox('Loại giảm giá','type_sale',@$data -> type_sale,0,array('1'=>'Phần trăm','2'=>'Giá trị'),$field_value = '', $field_label='');

	TemplateHelper::dt_edit_text(FSText :: _('Đơn hàng có giá trị trên'),'min_price',@$data -> min_price);

	// TemplateHelper::dt_edit_selectbox(FSText::_('Loại giảm giá(1: %, 2: Tiền )'),'type_sale',@$data -> type_sale,0,array(1=>'1',2=>'2'),$size = 10,0,1);
	TemplateHelper::dt_edit_text(FSText :: _('Số lượng được giảm'),'number_sale',@$data -> number_sale);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	
	$this -> dt_form_end(@$data);

?>

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