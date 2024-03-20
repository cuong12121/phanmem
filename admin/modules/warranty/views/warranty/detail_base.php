<table cellspacing="1" class="admintable">
<?php
	if(!empty($data)){
        TemplateHelper::dt_edit_text(FSText :: _('Ngày'),'date',date('d-m-Y',strtotime(@$data -> date)),'',60,1,0);
    }else{
        TemplateHelper::dt_edit_text(FSText :: _('Ngày'),'date',date('d-m-Y'),'',60,1,0);
    }
    TemplateHelper::dt_edit_selectbox(FSText::_('Công việc'),'job_id',@$data -> job_id,0,$array_job,$field_value = 'id', $field_label='name',$size = 1,0,0);
    TemplateHelper::dt_edit_text(FSText :: _('Mã vận đơn'),'tracking_code',@$data -> tracking_code,'',100,1,0);
    TemplateHelper::dt_edit_text(FSText :: _('Mã đơn hàng'),'code',@$data -> code,'',100,1,0);
     TemplateHelper::dt_edit_text(FSText :: _('SKU sản phẩm'),'product_code',@$data -> product_code,'',100,1,0);

    TemplateHelper::dt_edit_selectbox(FSText::_('Kho'),'warehouse_id',@$data -> warehouse_id,0,$warehouses,$field_value = 'id', $field_label='name',$size = 1,0,1);
	TemplateHelper::dt_edit_selectbox(FSText::_('Shop'),'shop_id',@$data -> shop_id,0,$shops,$field_value = 'id', $field_label='name',$size = 1,0,1);
    TemplateHelper::dt_edit_text(FSText :: _('Tên khách hàng'),'name_guest',@$data -> name_guest,'',100,1,0);
    TemplateHelper::dt_edit_text(FSText :: _('Số điện thoại khách'),'phone_guest',@$data -> phone_guest,'',100,1,0);
    TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ khách'),'address_guest',@$data -> address_guest,'',100,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Mô tả sản phẩm lỗi gì)'),'note',@$data -> note,'',100,5,1);
	TemplateHelper::dt_edit_text(FSText :: _('Link hình ảnh / Video'),'link_video',@$data -> link_video);
	$array_star = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
	TemplateHelper::dt_edit_selectbox(FSText::_('Số sao đánh giá'),'star',@$data -> star,0,$array_star,$field_value = 'id', $field_label='name',$size = 1,0,1);
?>
</table>

<script  type="text/javascript" language="javascript">
    $(function() {
        $( "#date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    });
</script>