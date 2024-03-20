<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/colorpicker/css/colorpicker.css" />
<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 

global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');
$this -> dt_form_begin();
// TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
TemplateHelper::dt_edit_text(FSText :: _('Họ tên'),'name',@$data -> name);
TemplateHelper::dt_edit_text(FSText :: _('Số điện thoại'),'phone',@$data -> phone);
TemplateHelper::dt_edit_text(FSText :: _('IMEI'),'imei',@$data -> imei);
TemplateHelper::dt_edit_text(FSText :: _('Tên máy'),'device_name',@$data -> device_name);
TemplateHelper::dt_edit_text(FSText :: _('Bào hành từ'),'begin_time',@$data -> begin_time?date('d-m-Y',strtotime(@$data -> begin_time)):'','','12',1,0,'Nhập dạng <strong>dd-mm-YYYY</strong>.');
TemplateHelper::dt_edit_text(FSText :: _('Hạn bảo hành'),'end_time',@$data -> end_time?date('d-m-Y',strtotime(@$data -> end_time)):'','','12',1,0,'Nhập dạng <strong>dd-mm-YYYY</strong>.');
TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
$this -> dt_form_end(@$data);

?>

    <script  type="text/javascript" language="javascript">
        $(function() {
            $( "#begin_time" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
            $( "#begin_time").change(function() {
                document.formSearch.submit();
            });

             $( "#end_time" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
            $( "#end_time").change(function() {
                document.formSearch.submit();
            });
        })

    </script>