<table cellspacing="1" class="admintable">
<?php
	if($_SESSION['ad_groupid'] ==1){
		
		if(!empty($data)){
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày'),'date',date('d-m-Y',strtotime(@$data -> date)),'',60,1,0);
	    }else{
	        TemplateHelper::dt_edit_text(FSText :: _('Ngày'),'date',date('d-m-Y'),'',60,1,0);
	    }

	    TemplateHelper::dt_edit_selectbox(FSText::_('Công việc'),'job_id',@$data -> job_id,0,$array_job,$field_value = 'id', $field_label='name',$size = 1,0,0);

	    TemplateHelper::dt_edit_text(FSText :: _('Mã vận đơn'),'code',@$data -> code,'',100,1,0);
	  //  TemplateHelper::dt_edit_selectbox(FSText::_('Sàn'),'platform_id',@$data -> platform_id,0,$platforms,$field_value = 'id', $field_label='name',$size = 1,0,1);
		TemplateHelper::dt_edit_text(FSText :: _('Chi tiết công việc)'),'note',@$data -> note,'',100,5,1);
		TemplateHelper::dt_edit_text(FSText :: _('Link hình ảnh / Video'),'link_video',@$data -> link_video);

		$array_star = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
		TemplateHelper::dt_edit_selectbox(FSText::_('Số sao đánh giá'),'star',@$data -> star,0,$array_star,$field_value = 'id', $field_label='name',$size = 1,0,1);
	}elseif($_SESSION['ad_groupid'] == 8){
?>
	<div class="form-group ">
		<label class="col-md-2 col-xs-12 control-label">Chi tiết công việc</label>
		<div class="col-md-10 col-xs-12">
			<?php echo $data->note ?>
		</div>
	</div>
<?php

		TemplateHelper::dt_edit_text(FSText :: _('Người thực hiện'),'name',@$data -> name,'',100,1,0);
		
		TemplateHelper::dt_edit_text(FSText :: _('Bộ phận chịu tránh nhiệm(Chịu phí)'),'room',@$data -> room,'',100,1,0);

		TemplateHelper::dt_edit_selectbox('Trạng thái','status',@$data -> status,'',$array_status,$field_value = '', $field_label='',$size = 1,0,0);

		TemplateHelper::dt_edit_text(FSText :: _('Lý do không hoàn thành'),'note2',@$data -> note2,'',100,5,1);
		TemplateHelper::dt_edit_text(FSText :: _('Mã chuyển hoàn cho khách'),'code_return',@$data -> code_return,'',100,1,0);
	}elseif($_SESSION['ad_groupid'] == 6){
		//TemplateHelper::dt_edit_text(FSText :: _('QL cho điểm'),'point',@$data -> point,'',60,1,0);
	}
?>
</table>

<script  type="text/javascript" language="javascript">
    $(function() {
        $( "#date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
    });
</script>