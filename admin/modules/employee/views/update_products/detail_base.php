<table cellspacing="1" class="admintable">
<?php
	if(1 ==1){
		TemplateHelper::dt_edit_text(FSText :: _('Tên sản phẩm'),'name',@$data -> name,'',100,1,0);
		TemplateHelper::dt_edit_text(FSText :: _('Mã sản phẩm'),'code_product',@$data -> code_product,'',100,1,0);

		// TemplateHelper::dt_edit_text(FSText :: _('Chiết yêu cầu'),'description',@$data -> description,'',100,3,1);

		TemplateHelper::dt_edit_text(FSText :: _('Số lượng'),'count',@$data -> count,'',100,1,0);

		TemplateHelper::dt_edit_text(FSText :: _('Nâng cấp gì'),'nang_cap',@$data -> nang_cap,'',100,5,1);

		TemplateHelper::dt_edit_text(FSText :: _('Giá'),'price',@$data -> price,'',100,1,0);

		TemplateHelper::dt_edit_text(FSText :: _('Thời gian sản xuất'),'date_san_xuat',@$data -> date_san_xuat,'',100,1,0);
	    
	    TemplateHelper::dt_edit_text(FSText :: _('Giá VCQT'),'price_import',@$data -> price_import,'',100,1,0);

	    TemplateHelper::dt_edit_text(FSText :: _('Giá dự kiến về việt nam'),'price_to_hn',@$data -> price_to_hn,'',100,1,0);



	  //  TemplateHelper::dt_edit_selectbox(FSText::_('Đã tìm xong'),'is_find',@$data -> is_find,0,$array_find,$field_value = 'id', $field_label='name',$size = 1,0,0);

		//TemplateHelper::dt_edit_text(FSText :: _('Lý do không hoàn thành'),'not_finish',@$data -> not_finish,'',100,5,1);
		//TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'note',@$data -> note,'',100,5,1);
		//TemplateHelper::dt_edit_text(FSText :: _('Đề xuất'),'propose',@$data -> propose,'',100,5,1);
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
	     TemplateHelper::dt_edit_text(FSText :: _('Time line (Bao phút)'),'time_line',@$data -> time_line,'',100,1,0);

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
    $(function(){
    	$( "#date_phat_hanh" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    	$( "#ngay_dat_hang" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
        $( "#date_to_ha_noi" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    });
</script>