<table cellspacing="1" class="admintable">
<?php

		TemplateHelper::dt_edit_text(FSText :: _('Tên sản phẩm'),'name',@$data -> name,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Mã sản phẩm'),'code_product',@$data -> code_product,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Chi tiết yêu cầu'),'description',@$data -> description,'',100,3,1);
		TemplateHelper::dt_edit_text(FSText :: _('Số lượng'),'count',@$data -> count,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Yêu cầu nhập cho miền'),'yeu_cau_kho',@$data -> yeu_cau_kho,'',100,1,0);
	    TemplateHelper::dt_sepa();
?>
<div class="form-group ">
	<label class="col-md-2 col-xs-12 control-label red"><strong>KẾT QUẢ</strong></label>
	<div class="col-md-10 col-xs-12"></div>
</div>

<?php
		//TemplateHelper::dt_edit_text(FSText :: _('List 5 link nhà cung cấp'),'link',@$data -> link,'',100,5,1);
		TemplateHelper::dt_edit_selectbox('Phương án xử lý','plan_id',@$data -> plan_id,'',$array_plan,$field_value = '', $field_label='',$size = 1,0,1);
		
		TemplateHelper::dt_edit_text(FSText :: _('Giá'),'price_product',@$data -> price_product,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Thời gian sản xuất'),'date_san_xuat',@$data -> date_san_xuat,'',100,1,0);
	    //TemplateHelper::dt_edit_text(FSText :: _('Giá VCQT'),'price_import',@$data -> price_import,'',100,1,0);
	    TemplateHelper::dt_edit_text(FSText :: _('Giá dự kiến về việt nam'),'price_to_hn',@$data -> price_to_hn,'',100,1,0);
	    TemplateHelper::dt_sepa();


	  //  TemplateHelper::dt_edit_selectbox(FSText::_('Đã tìm xong'),'is_find',@$data -> is_find,0,$array_find,$field_value = 'id', $field_label='name',$size = 1,0,0);
	   
		
		TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'note',@$data -> note,'',100,5,1);
		TemplateHelper::dt_edit_text(FSText :: _('Đề xuất'),'propose',@$data -> propose,'',100,5,1);
		TemplateHelper::dt_edit_text(FSText :: _('Time line (Bao phút)'),'time_line',@$data -> time_line,'',100,1,0);
		TemplateHelper::dt_edit_selectbox('Duyệt nhập','is_import',@$data -> is_import,'',$array_import,$field_value = '', $field_label='',$size = 1,0,0);
		TemplateHelper::dt_edit_text(FSText :: _('Ngày đặt hàng'),'ngay_dat_hang',check_empty_date(@$data-> ngay_dat_hang),'',60,1,0);
	    TemplateHelper::dt_edit_text(FSText :: _('Số lượng thực nhập'),'so_luong_thuc_nhap',@$data -> so_luong_thuc_nhap,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('ĐVVC'),'dvvc',@$data -> dvvc,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Mã đơn hàng'),'code',@$data -> code,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Mã ký gửi'),'code_deposit',@$data -> code_deposit,'',100,1,0);

		TemplateHelper::dt_edit_text(FSText :: _('Ngày phát hành'),'date_phat_hanh',check_empty_date(@$data-> date_phat_hanh),'',60,1,0);

		TemplateHelper::dt_edit_text(FSText :: _('Ngày đến kho TQ'),'date_to_tq',check_empty_date(@$data-> date_to_tq),'',60,1,0);

	    TemplateHelper::dt_edit_text(FSText :: _('Ngày hàng đến kho'),'date_to_ha_noi',check_empty_date(@$data-> date_to_ha_noi),'',60,1,0);

	    TemplateHelper::dt_sepa();
?>
<div class="form-group ">
	<label class="col-md-2 col-xs-12 control-label red"><strong>SỐ LƯỢNG NHẬN THỰC</strong></label>
	<div class="col-md-10 col-xs-12"></div>
</div>
<?php	   	
	    TemplateHelper::dt_edit_text(FSText :: _('Số kiện'),'so_kien',@$data -> so_kien,'',60,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Số lượng 1 kiện'),'so_luong_mot_kien',@$data -> so_luong_mot_kien,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Tổng số lượng SP'),'tong_so_luong_sp',@$data -> tong_so_luong_sp,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Tổng cân nặng cả lô'),'tong_can_nang_cua_lo',@$data -> tong_can_nang_cua_lo,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Tổng thể tích cả lô'),'tong_the_tich_cua_lo',@$data -> tong_the_tich_cua_lo,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Ghi chú của kho'),'ghi_chu_cua_kho',@$data -> ghi_chu_cua_kho,'',100,5,1);
	    TemplateHelper::dt_sepa();
?>
<div class="form-group ">
	<label class="col-md-2 col-xs-12 control-label red"><strong>PHÂN HÀNG MIỀN BẮC</strong></label>
	<div class="col-md-10 col-xs-12"></div>
</div>
<?php	   	
	    TemplateHelper::dt_edit_text(FSText :: _('Theo dự báo'),'phan_theo_du_bao_mb',@$data -> phan_theo_du_bao_mb,'',60,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Số lượng thực'),'phan_luong_thuc_mb',@$data -> phan_luong_thuc_mb,'',100,1,0);
	    TemplateHelper::dt_sepa();
?>
<div class="form-group ">
	<label class="col-md-2 col-xs-12 control-label red"><strong>PHÂN HÀNG MIỀN NAM</strong></label>
	<div class="col-md-10 col-xs-12"></div>
</div>
<?php	

	    TemplateHelper::dt_edit_text(FSText :: _('Theo dự báo'),'phan_theo_du_bao_mn',@$data -> phan_theo_du_bao_mn,'',60,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Số lượng thực'),'phan_luong_thuc_mn',@$data -> phan_luong_thuc_mn,'',100,1,0);
	    TemplateHelper::dt_sepa();


	    TemplateHelper::dt_edit_text(FSText :: _('GHI CHÚ [Của NV nhập hàng]'),'note_nhan_vien_nhan_hang',@$data -> note_nhan_vien_nhan_hang,'',100,5,1);
	    TemplateHelper::dt_edit_text(FSText :: _('Phản ánh chất lượng(Phòng bảo hành)'),'phan_anh_phong_bh',@$data -> phan_anh_phong_bh,'',100,5,1);
	    TemplateHelper::dt_edit_text(FSText :: _('Hàng thiếu, lỗi vỡ'),'product_error',@$data -> product_error,'',100,5,1);
	    TemplateHelper::dt_edit_text(FSText :: _('Nhập hàng khiếu nại'),'nhap_hang_khieu_nai',@$data -> nhap_hang_khieu_nai,'',100,5,1);
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
		

		TemplateHelper::dt_edit_text(FSText :: _('Lý do không hoàn thành'),'not_finish',@$data -> not_finish,'',100,5,1);
?>
</table>

<script  type="text/javascript" language="javascript">
    $(function() {
    	
    	$( "#date_phat_hanh" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    	$( "#ngay_dat_hang" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
        $( "#date_to_ha_noi" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
        $( "#date_to_tq" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    });
</script>