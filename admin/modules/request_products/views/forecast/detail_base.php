<table cellspacing="1" class="admintable">
<?php
	if(1 ==1){
		TemplateHelper::dt_edit_text(FSText :: _('Tên sản phẩm'),'name',@$data -> name,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Mã sản phẩm'),'code',@$data -> code,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Giá nhập'),'price_import',@$data -> price_import,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Tổng bán offline'),'buy_offline',@$data -> buy_offline,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Tổng đặt online miền bắc'),'buy_online_mb',@$data -> buy_online_mb,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Tổng đặt online miền nam'),'buy_online_mn',@$data -> buy_online_mn,'',100,1,0);
		
		TemplateHelper::dt_edit_text(FSText :: _('Tồn kho có thể bán miền bắc'),'buy_can_mb',@$data -> buy_can_mb,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Tồn kho có thể bán miền nam'),'buy_can_mn',@$data -> buy_can_mn,'',100,1,0);

		TemplateHelper::dt_edit_text(FSText :: _('Sắp chuyển tới kho miền bắc'),'sap_chuyen_toi_mb',@$data -> sap_chuyen_toi_mb,'',100,1,0);

		TemplateHelper::dt_edit_text(FSText :: _('Sắp chuyển tới kho miền nam'),'sap_chuyen_toi_mn',@$data -> sap_chuyen_toi_mn,'',100,1,0);

		TemplateHelper::dt_edit_text(FSText :: _('Chờ nhập hàng miền bắc'),'cho_nhap_mb',@$data -> cho_nhap_mb,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Chờ nhập hàng miền nam'),'cho_nhap_mn',@$data -> cho_nhap_mn,'',100,1,0);

		TemplateHelper::dt_edit_text(FSText :: _('Phân hàng miền bắc (%)'),'phan_hang_mb',@$data -> phan_hang_mb,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Phân hàng miền nam (%)'),'phan_hang_mn',@$data -> phan_hang_mn,'',100,1,0);

	    TemplateHelper::dt_edit_selectbox(FSText::_('Phân việc cho nhân viên'),'employees_id',@$data -> employees_id,0,$employees,$field_value = 'id', $field_label='fullname',$size = 1,0,1);
	}
?>
</table>

<script  type="text/javascript" language="javascript">
    $(function() {
    	
    	// $( "#date_phat_hanh" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    	//$( "#date_finish" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
        // $( "#date_to_ha_noi" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    });
</script>