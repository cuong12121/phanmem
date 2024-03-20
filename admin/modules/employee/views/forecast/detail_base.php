<table cellspacing="1" class="admintable">
<?php
	if(1 ==1){
		TemplateHelper::dt_edit_text(FSText :: _('Tên sản phẩm'),'name',@$data -> name,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Mã sản phẩm'),'code_product',@$data -> code_product,'',100,1,0);
		// TemplateHelper::dt_edit_text(FSText :: _('Giá nhập'),'price_import',@$data -> price_import,'',100,1,0);
		// TemplateHelper::dt_edit_text(FSText :: _('Tổng bán offline'),'buy_offline',@$data -> buy_offline,'',100,1,0);
		// TemplateHelper::dt_edit_text(FSText :: _('Tổng đặt online miền bắc'),'buy_online_mb',@$data -> buy_online_mb,'',100,1,0);
		// TemplateHelper::dt_edit_text(FSText :: _('Tổng đặt online miền nam'),'buy_online_mn',@$data -> buy_online_mn,'',100,1,0);
		
		// TemplateHelper::dt_edit_text(FSText :: _('Tồn kho có thể bán miền bắc'),'buy_can_mb',@$data -> buy_can_mb,'',100,1,0);
		// TemplateHelper::dt_edit_text(FSText :: _('Tồn kho có thể bán miền nam'),'buy_can_mn',@$data -> buy_can_mn,'',100,1,0);

		// TemplateHelper::dt_edit_text(FSText :: _('Sắp chuyển tới kho miền bắc'),'sap_chuyen_toi_mb',@$data -> sap_chuyen_toi_mb,'',100,1,0);

		// TemplateHelper::dt_edit_text(FSText :: _('Sắp chuyển tới kho miền nam'),'sap_chuyen_toi_mn',@$data -> sap_chuyen_toi_mn,'',100,1,0);

		// TemplateHelper::dt_edit_text(FSText :: _('Chờ nhập hàng miền bắc'),'cho_nhap_mb',@$data -> cho_nhap_mb,'',100,1,0);
		// TemplateHelper::dt_edit_text(FSText :: _('Chờ nhập hàng miền nam'),'cho_nhap_mn',@$data -> cho_nhap_mn,'',100,1,0);

		// TemplateHelper::dt_edit_text(FSText :: _('Phân hàng miền bắc (%)'),'phan_hang_mb',@$data -> phan_hang_mb,'',100,1,0);
		// TemplateHelper::dt_edit_text(FSText :: _('Phân hàng miền nam (%)'),'phan_hang_mn',@$data -> phan_hang_mn,'',100,1,0);

		// TemplateHelper::dt_sepa();
		TemplateHelper::dt_edit_text(FSText :: _('Số lượng'),'count',@$data -> count,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('List 5 link nhà cung cấp'),'link',@$data -> link,'',100,5,1);
		TemplateHelper::dt_edit_text(FSText :: _('Giá SP mới'),'price_product_new',@$data -> price_product_new,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Giá RMB'),'price_rmb',@$data -> price_rmb,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Giá sản phẩm cũ'),'price_product_old',@$data -> price_product_old,'',100,1,0);

		TemplateHelper::dt_edit_text(FSText :: _('Giá RMB Cũ'),'price_rmb_old',@$data -> price_rmb_old,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Phí vận chuyển mới'),'price_ship',@$data -> price_ship,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Phí vận chuyển cũ'),'price_ship_old',@$data -> price_ship_old,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Tối ưu'),'toi_uu',@$data -> toi_uu,'',100,1,0);
	
		TemplateHelper::dt_edit_text(FSText :: _('Giá dự kiến về Kho'),'price_to_hn',@$data -> price_to_hn,'',100,1,0);

		TemplateHelper::dt_edit_text(FSText :: _('Lý do không hoàn thành'),'not_finish',@$data -> not_finish,'',100,5,1);
		TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'note',@$data -> note,'',100,5,1);
		TemplateHelper::dt_edit_text(FSText :: _('Đề xuất'),'propose',@$data -> propose,'',100,5,1);
		//TemplateHelper::dt_edit_selectbox('Duyệt nhập','is_import',@$data -> is_import,'',$array_import,$field_value = '', $field_label='',$size = 1,0,0);
		//TemplateHelper::dt_edit_selectbox('Duyệt nhập','is_import',@$data -> is_import,'',$array_import,$field_value = '', $field_label='',$size = 1,0,0);
		if(!empty($data->ngay_dat_hang)){
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày đặt hàng'),'ngay_dat_hang',date('d-m-Y',strtotime(@$data -> ngay_dat_hang)),'',60,1,0);
	    }else{
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày đặt hàng'),'ngay_dat_hang','','',60,1,0);
	    }
		TemplateHelper::dt_edit_text(FSText :: _('ĐVVC'),'dvvc',@$data -> dvvc,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Mã đơn hàng'),'code',@$data -> code,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Mã ký gửi'),'code_deposit',@$data -> code_deposit,'',100,1,0);

		if(!empty($data->date_phat_hanh)){
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày phát hành'),'date_phat_hanh',date('d-m-Y',strtotime(@$data -> date_to_tq)),'',60,1,0);
	    }else{
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày phát hành'),'date_phat_hanh','','',60,1,0);
	    }

		if(!empty($data->date_to_tq)){
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày đến kho TQ'),'date_to_tq',date('d-m-Y',strtotime(@$data -> date_to_tq)),'',60,1,0);
	    }else{
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày đến kho TQ'),'date_to_tq','','',60,1,0);
	    }

	    if(!empty($data->date_to_ha_noi)){
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày hàng đến kho'),'date_to_ha_noi',date('d-m-Y',strtotime(@$data -> date_to_ha_noi)),'',60,1,0);
	    }else{
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày hàng đến kho'),'date_to_ha_noi','','',60,1,0);
	    }

	    TemplateHelper::dt_edit_text(FSText :: _('GHI CHÚ [Của NV nhập hàng]'),'note_nhan_vien_nhan_hang',@$data -> note_nhan_vien_nhan_hang,'',100,5,1);
	    TemplateHelper::dt_edit_text(FSText :: _('GHI CHÚ NHẬN HÀNG'),'note_nhan_hang',@$data -> note_nhan_hang,'',100,5,1);
	    TemplateHelper::dt_edit_text(FSText :: _('Hàng thiếu, lỗi vỡ'),'product_error',@$data -> product_error,'',100,5,1);
	    TemplateHelper::dt_edit_text(FSText :: _('Nhập hàng khiếu nại'),'nhap_hang_khieu_nai',@$data -> nhap_hang_khieu_nai,'',100,5,1);
		
		TemplateHelper::dt_sepa();
		
		TemplateHelper::dt_edit_text(FSText :: _('Time line (Bao phút)'),'time_line',@$data -> time_line,'',100,1,0);
	  
	   	//TemplateHelper::dt_edit_selectbox(FSText::_('Phân việc cho nhân viên'),'employees_id',@$data -> employees_id,0,$employees,$field_value = 'id', $field_label='fullname',$size = 1,0,1);
	   	?>
		<div class="form-group">
	        <label class="col-md-2 col-xs-12 control-label">Chú ý:</label>
	        <div class="col-md-10 col-xs-12 red">
	            Nếu chuyển sang trạng thái Hoàn Thành bạn sẽ không thay đổi lại trạng thái được nữa !
	        </div>
	    </div>
		<?php
		if(@$data -> status != 2){
			TemplateHelper::dt_edit_selectbox('Trạng thái','status',@$data -> status,'',$array_status,$field_value = '', $field_label='',$size = 1,0,0);
		}
	}
?>
</table>
<script  type="text/javascript" language="javascript">
    $(function() {
    	
    	$( "#date_phat_hanh" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    	$( "#ngay_dat_hang" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
        $( "#date_to_ha_noi" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    });
</script>