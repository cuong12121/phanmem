<table cellspacing="1" class="admintable">
<?php
	
	if($_SESSION['ad_groupid'] == 8){	
		if(!empty($data)){
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày'),'date',date('d-m-Y',strtotime(@$data -> date)),'',60,1,0);
	    }else{
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày'),'date',date('d-m-Y'),'',60,1,0);
	    }
		TemplateHelper::dt_edit_text(FSText :: _('Yêu cầu nhập linh kiện'),'name',@$data -> name);
		TemplateHelper::dt_edit_text(FSText :: _('SKU'),'sku',@$data -> sku);
		TemplateHelper::dt_edit_text(FSText :: _('Chi tiết yêu cầu'),'note',@$data -> note,'',100,5,1);
		TemplateHelper::dt_edit_text(FSText :: _('Số lượng'),'count',@$data -> count);
		//TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ khách hàng'),'address_custommer',@$data -> address_custommer);
		
	}elseif($_SESSION['ad_groupid'] == 6){
		// TemplateHelper::dt_edit_selectbox('Phân việc cho nhân viên','employees_id',@$data -> employees_id,'',$employees,$field_value = 'id', $field_label='name',$size = 1,0,0);
		TemplateHelper::dt_edit_selectbox(FSText::_('Phân việc cho nhân viên'),'employees_id',@$data -> employees_id,0,$employees,$field_value = 'id', $field_label='fullname',$size = 1,0,1);
	}elseif($_SESSION['ad_groupid'] == 2){
		TemplateHelper::dt_edit_selectbox('Trạng thái','status',@$data -> status,'',$array_status,$field_value = '', $field_label='',$size = 1,0,0);
	}

?>
</table>

<script  type="text/javascript" language="javascript">
    $(function() {
        $( "#date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    });
</script>