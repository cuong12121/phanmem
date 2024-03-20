<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/colorpicker/css/colorpicker.css" />
<table cellspacing="1" class="admintable">
    <?php
    TemplateHelper::dt_edit_text(FSText :: _('Tên máy'),'device_name',@$data -> device_name);
    TemplateHelper::dt_edit_text(FSText :: _('Nội dung sửa chữa'),'more_info',@$data -> more_info);
    TemplateHelper::dt_edit_text(FSText :: _('Thời điểm trả máy'),'end_time',$data -> end_time!='0000-00-00'?date('d-m-Y',strtotime($data -> end_time)):'','','12',1,0,'Nhập dạng <strong>dd-mm-YYYY</strong>.');
    TemplateHelper::dt_checkbox(FSText::_('Sửa xong'),'published',@$data -> published,0);
     // TemplateHelper::dt_edit_text(FSText :: _('Thời điểm trả máy'),'email',@$data -> email);
    ?>
    <?php 
    TemplateHelper::dt_edit_text(FSText :: _('Giá dịch vụ'),'total',@$data -> total);
    ?>
</table>
<script  type="text/javascript" language="javascript">
    $(function() {
        $( "#end_time" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
        $( "#end_time").change(function() {
            document.formSearch.submit();
        });
    })
</script>
<style>
#published_date {
    float: left;
}
</style>