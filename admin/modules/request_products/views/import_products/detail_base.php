<table cellspacing="1" class="admintable">
<?php
	
	TemplateHelper::dt_edit_text(FSText :: _('Tên sản phẩm'),'name',@$data -> name,'',100,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'description',@$data -> description,'',100,3,1);
	TemplateHelper::dt_edit_text(FSText :: _('Số lượng'),'count',@$data -> count,'',100,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Yêu cầu nhập cho miền'),'yeu_cau_kho',@$data -> yeu_cau_kho,'',100,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('List 5 link nhà cung cấp'),'link',@$data -> link,'',100,5,1);
		
	
?>
</table>

<script  type="text/javascript" language="javascript">
    $(function() {
    	
    	$( "#date_phat_hanh" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    	//$( "#date_finish" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
        $( "#date_to_ha_noi" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    });
</script>