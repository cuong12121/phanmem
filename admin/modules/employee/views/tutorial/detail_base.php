<table cellspacing="1" class="admintable">
<?php
	if($_SESSION['ad_groupid'] ==1){
		
		if(!empty($data)){
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày'),'date',date('d-m-Y',strtotime(@$data -> date)),'',60,1,0);
	    }else{
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày'),'date',date('d-m-Y'),'',60,1,0);
	    }

	    TemplateHelper::dt_edit_selectbox(FSText::_('Shop'),'shop_id',@$data -> shop_id,0,$shops,$field_value = 'id', $field_label='name',$size = 1,0,1);
	    
	    TemplateHelper::dt_edit_selectbox(FSText::_('Kho'),'warehouse_id',@$data -> warehouse_id,0,$warehouses,$field_value = 'id', $field_label='name',$size = 1,0,1);
	    TemplateHelper::dt_edit_selectbox(FSText::_('Sàn'),'platform_id',@$data -> platform_id,0,$platforms,$field_value = 'id', $field_label='name',$size = 1,0,1);
		
		TemplateHelper::dt_edit_text(FSText :: _('Tracking code'),'tracking_code',@$data -> tracking_code);
		TemplateHelper::dt_edit_text(FSText :: _('SKU'),'sku',@$data -> sku);
		TemplateHelper::dt_edit_text(FSText :: _('Tên khách hàng'),'name_custommer',@$data -> name_custommer);
		TemplateHelper::dt_edit_text(FSText :: _('SĐT khách hàng'),'phone_custommer',@$data -> phone_custommer);
		TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ khách hàng'),'address_custommer',@$data -> address_custommer);
		TemplateHelper::dt_edit_text(FSText :: _('NBH mô tả lỗi'),'note',@$data -> note,'',100,5,1);

		$array_star = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
		TemplateHelper::dt_edit_selectbox(FSText::_('Số sao đánh giá'),'star',@$data -> star,0,$array_star,$field_value = 'id', $field_label='name',$size = 1,0,1);

	}elseif($_SESSION['ad_groupid'] == 8){

		TemplateHelper::dt_edit_selectbox('Trạng thái','status',@$data -> status,'',$array_status,$field_value = '', $field_label='',$size = 1,0,0);

		TemplateHelper::dt_edit_text(FSText :: _('Kỹ thuật kết luận lỗi'),'note2',@$data -> note2,'',100,5,1);
	}elseif($_SESSION['ad_groupid'] == 6){
		TemplateHelper::dt_edit_text(FSText :: _('QL cho điểm'),'point',@$data -> point,'',60,1,0);
	}
?>
</table>

<script  type="text/javascript" language="javascript">
    $(function() {
        $( "#date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    });
</script>