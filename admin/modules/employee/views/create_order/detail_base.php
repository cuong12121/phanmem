<table cellspacing="1" class="admintable">
<?php
	
	
		if(!empty($data)){
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày'),'date',date('d-m-Y',strtotime(@$data -> date)),'',60,1,0);
	    }else{
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày'),'date',date('d-m-Y'),'',60,1,0);
	    }
		TemplateHelper::dt_edit_text(FSText :: _('Yêu cầu nhập linh kiện'),'name',@$data -> name);
		TemplateHelper::dt_edit_text(FSText :: _('SKU'),'sku',@$data -> sku);
		TemplateHelper::dt_edit_text(FSText :: _('Chi tiết yêu cầu'),'note',@$data -> note,'',100,5,1);
		TemplateHelper::dt_edit_text(FSText :: _('Số lượng'),'count',@$data -> count);

		//TemplateHelper::dt_edit_selectbox(FSText::_('Phân việc cho nhân viên'),'employees_id',@$data -> employees_id,0,$employees,$field_value = 'id', $field_label='fullname',$size = 1,0,1);
		TemplateHelper::dt_edit_selectbox('Phương án xử lý','plan_id',@$data -> plan_id,'',$array_plan,$field_value = '', $field_label='',$size = 1,0,1);
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
	

?>
</table>

<script  type="text/javascript" language="javascript">
    $(function() {
        $( "#date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    });
</script>