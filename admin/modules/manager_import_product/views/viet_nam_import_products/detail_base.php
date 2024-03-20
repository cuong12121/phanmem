<table cellspacing="1" class="admintable">
<?php

	

		TemplateHelper::dt_edit_text(FSText :: _('Ngày thực hiện'),'ngay_thuc_hien',check_empty_date(@$data-> ngay_thuc_hien),'',60,1,0);
	    TemplateHelper::dt_edit_text(FSText :: _('Mã gian hàng'),'ma_gian_hang',@$data -> ma_gian_hang,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Tên sản phẩm'),'name',@$data -> name,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Mã sản phẩm'),'code_product',@$data -> code_product,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Chi tiết yêu cầu'),'description',@$data -> description,'',100,3,1);
		TemplateHelper::dt_edit_text(FSText :: _('Số lượng'),'count',@$data -> count,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Yêu cầu nhập cho miền'),'yeu_cau_kho',@$data -> yeu_cau_kho,'',100,1,0);
	 
		TemplateHelper::dt_edit_selectbox('Duyệt nhập','is_import',@$data -> is_import,'',$array_import,$field_value = '', $field_label='',$size = 1,0,0);

	   
		TemplateHelper::dt_sepa();
	
		TemplateHelper::dt_edit_text(FSText :: _('Phân miền bắc'),'phan_luong_thuc_mb',@$data -> phan_luong_thuc_mb,'',100,1,0);
	   
		TemplateHelper::dt_edit_text(FSText :: _('Phân miền nam'),'phan_luong_thuc_mn',@$data -> phan_luong_thuc_mn,'',100,1,0);
	    TemplateHelper::dt_sepa();


	    TemplateHelper::dt_edit_text(FSText :: _('Ghi chú gọi hàng'),'note_nhan_vien_nhan_hang',@$data -> note_nhan_vien_nhan_hang,'',100,5,1);

	    TemplateHelper::dt_edit_text(FSText :: _('Giá nhập'),'price_import',@$data -> price_import,'',100,1,0);

	    TemplateHelper::dt_edit_text(FSText :: _('Thông tin NCC'),'thong_tin_ncc',@$data -> thong_tin_ncc,'',100,5,1);

	    TemplateHelper::dt_edit_text(FSText :: _('Ngày đặt hàng'),'ngay_dat_hang',check_empty_date(@$data-> ngay_dat_hang),'',60,1,0);


	    TemplateHelper::dt_edit_text(FSText :: _('Ngày hàng đến kho'),'date_to_ha_noi',check_empty_date(@$data-> date_to_ha_noi),'',60,1,0);
 	
	
	    if($_SESSION['ad_groupid'] != 3){
	    TemplateHelper::dt_edit_selectbox(FSText::_('Phân việc cho nhân viên'),'employees_id',@$data -> employees_id,0,$employees,$field_value = 'id', $field_label='fullname',$size = 1,0,1);
	   	}

	  	if($_SESSION['ad_groupid'] == 3){
		?>

		<div class="form-group">
	        <label class="col-md-2 col-xs-12 control-label">Chú ý:</label>
	        <div class="col-md-10 col-xs-12 red">
	            Nếu chuyển sang trạng thái Hoàn Thành bạn sẽ không chỉnh sửa được nữa !
	        </div>
	    </div>

<?php
	}
	
	    TemplateHelper::dt_edit_selectbox('Trạng thái','status',@$data -> status,'',$array_status,$field_value = '', $field_label='',$size = 1,0,0);
		
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