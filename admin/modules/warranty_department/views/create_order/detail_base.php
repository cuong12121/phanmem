<table cellspacing="1" class="admintable">
<?php
	
	
	TemplateHelper::dt_edit_text(FSText :: _('Yêu cầu nhập linh kiện'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Mã sản phẩm'),'code_product',@$data -> code_product);
	TemplateHelper::dt_edit_text(FSText :: _('Chi tiết yêu cầu'),'note',@$data -> note,'',100,5,1);
	TemplateHelper::dt_edit_text(FSText :: _('Số lượng'),'count',@$data -> count);
	TemplateHelper::dt_edit_text(FSText :: _('Yêu cầu nhập cho miền'),'yeu_cau_kho',@$data -> yeu_cau_kho,'',100,1,0);
	

?>
</table>

<script  type="text/javascript" language="javascript">
    $(function() {
        $( "#date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    });
</script>