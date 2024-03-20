<table cellspacing="1" class="admintable">
<?php
		TemplateHelper::dt_edit_text(FSText :: _('Ngày thực hiện'),'ngay_thuc_hien',check_empty_date(@$data-> ngay_thuc_hien),'',60,1,0);
	    TemplateHelper::dt_edit_text(FSText :: _('Mã gian hàng'),'ma_gian_hang',@$data -> ma_gian_hang,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Tên sản phẩm'),'name',@$data -> name,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Mã sản phẩm'),'code_product',@$data -> code_product,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Chi tiết yêu cầu'),'description',@$data -> description,'',100,3,1);
		TemplateHelper::dt_edit_text(FSText :: _('Số lượng'),'count',@$data -> count,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Yêu cầu nhập cho miền'),'yeu_cau_kho',@$data -> yeu_cau_kho,'',100,1,0);
		//TemplateHelper::dt_edit_text(FSText :: _('Ghi chú gọi hàng'),'note_nhan_vien_nhan_hang',@$data -> note_nhan_vien_nhan_hang,'',100,5,1);
	 
?>
</table>

<script  type="text/javascript" language="javascript">
    $(function() {
    	$("#ngay_thuc_hien").datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    	$( "#date_phat_hanh" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    	$( "#ngay_dat_hang" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
        $( "#date_to_ha_noi" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
       
        
    });
</script>