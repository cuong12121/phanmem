
<?php
	TemplateHelper::dt_tab_title(FSText :: _('Thông tin bảo hiểm'));
	TemplateHelper::dt_edit_text(FSText :: _('Số sổ BHXH'),'so_so_bhxh',@$insurance -> so_so_bhxh,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Số thẻ BHYT'),'so_so_bhyt',@$insurance -> so_so_bhyt,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Mã tỉnh cấp'),'ma_tinh_cap',@$insurance -> ma_tinh_cap,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Đăng ký khám chữa bệnh'),'dang_ky_kham_chua_benh',@$insurance -> dang_ky_kham_chua_benh,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Trạng thái sổ'),'trang_thai_so',@$insurance -> trang_thai_so,'',60,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Pháp nhân'),'phap_nhan',@$insurance -> phap_nhan,'',60,1,0);

	TemplateHelper::dt_tab_title(FSText :: _('Nghiệp vụ báo tăng'));
	TemplateHelper::dt_edit_text(FSText :: _('NV hoàn thiện HS'),'nv_hoan_thien_hs',date('d-m-Y',strtotime(@$insurance -> nv_hoan_thien_hs)),'',60,1,0,'','','col-md-2','col-md-10 date_div');
	TemplateHelper::dt_edit_text(FSText :: _('NS hoàn thiện HS'),'ns_hoan_thien_hs',date('d-m-Y',strtotime(@$insurance -> ns_hoan_thien_hs)),'',60,1,0,'','','col-md-2','col-md-10 date_div');
	TemplateHelper::dt_edit_text(FSText :: _('Ngày nhận thẻ BHYT'),'ngay_nhan_the_bhyt',date('d-m-Y',strtotime(@$insurance -> ngay_nhan_the_bhyt)),'',60,1,0,'','','col-md-2','col-md-10 date_div');
	TemplateHelper::dt_edit_text(FSText :: _('Ngày trả thẻ BHYT'),'ngay_tra_the_bhyt',date('d-m-Y',strtotime(@$insurance -> ngay_tra_the_bhyt)),'',60,1,0,'','','col-md-2','col-md-10 date_div');

	TemplateHelper::dt_tab_title(FSText :: _('Nghiệp vụ báo giảm'));
	TemplateHelper::dt_edit_text(FSText :: _('Ngày nhận sổ BH từ NLĐ'),'ngay_nhan_so_bh_tu_nld',date('d-m-Y',strtotime(@$insurance -> ngay_nhan_so_bh_tu_nld)),'',60,1,0,'','','col-md-2','col-md-10 date_div');

	TemplateHelper::dt_edit_text(FSText :: _('NS hoàn thiện HS'),'nv_hoan_thien_hs_bg',date('d-m-Y',strtotime(@$insurance -> nv_hoan_thien_hs_bg)),'',60,1,0,'','','col-md-2','col-md-10 date_div');

	TemplateHelper::dt_edit_text(FSText :: _('Ngày nhận sổ BH đã chốt'),'ngay_nhan_so_bh_chot',date('d-m-Y',strtotime(@$insurance -> ngay_nhan_so_bh_chot)),'',60,1,0,'','','col-md-2','col-md-10 date_div');
	
	TemplateHelper::dt_edit_text(FSText :: _('Ngày trả số cho NLĐ'),'ngay_tra_so_cho_nld',date('d-m-Y',strtotime(@$insurance -> ngay_tra_so_cho_nld)),'',60,1,0,'','','col-md-2','col-md-10 date_div');

?>

<script type="text/javascript">
	$(function() {
		$(".date_div input").datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
	});

</script>