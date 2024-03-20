<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.js"></script>

<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/colorpicker/js/eye.js"></script>

<!-- FOR TAB -->	
<script>
	$(document).ready(function() {
		$("#tabs").tabs();
	});
</script>
<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

$this -> dt_form_begin(0);
?>

<div class="col-12 col-md-6" style="margin-top: 20px;">
	<div class="panel panel-default">
		<div class="panel-heading">Thông tin</div>
		<div class="panel-body">
			<?php 
			TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name,'','',1,0,'','','col-md-2','col-md-10','col-12 col-md-6');
			TemplateHelper::dt_edit_text(FSText :: _('Code'),'code',@$data -> code,'','',1,0,'','','col-md-2','col-md-10','col-12 col-md-6');
			TemplateHelper::dt_edit_text(FSText :: _('Điện thoại'),'telephone',@$data -> telephone,'','',1,0,'','','col-md-2','col-md-10','col-12 col-md-6');
			TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email,'','',1,0,'','','col-md-2','col-md-10','col-12 col-md-6');
			TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ'),'address',@$data -> address,'','',1,0,'','','col-md-2','col-md-10','col-12 col-md-6');
			TemplateHelper::dt_edit_text(FSText :: _('Mã số thuế'),'mst',@$data -> mst,'','',1,0,'','','col-md-2','col-md-10','col-12 col-md-6');
			TemplateHelper::dt_edit_text(FSText :: _('Số CMND'),'smt',@$data -> cmt,'','',1,0,'','','col-md-2','col-md-10','col-12 col-md-6');
			?>

			<div class="clearfix"></div>
			<?php

			TemplateHelper::dt_edit_selectbox('Loại hình','type',@$data -> type,0,array('1'=>'Cá nhân','2'=>'Doanh nghiệp'),$field_value = '', $field_label='');
			TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
			?>
		</div>
	</div>
</div>


<div class="col-12 col-md-6" style="margin-top: 20px;">
	<div class="panel panel-default">
		<div class="panel-heading">Thanh toán</div>
		<div class="panel-body">
				<?php 
				TemplateHelper::dt_edit_text(FSText :: _('Ngân hàng'),'bank_name',@$data -> bank_name,'','',1,0,'','','col-md-2','col-md-10','col-12 col-md-6');
				TemplateHelper::dt_edit_text(FSText :: _('Chi nhánh'),'bank_branch',@$data -> bank_branch,'','',1,0,'','','col-md-2','col-md-10','col-12 col-md-6');
				TemplateHelper::dt_edit_text(FSText :: _('Số TK'),'bank_number',@$data -> bank_number,'','',1,0,'','','col-md-2','col-md-10','col-12 col-md-6');
				TemplateHelper::dt_edit_text(FSText :: _('Chủ TK'),'bank_username',@$data -> bank_username,'','',1,0,'','','col-md-2','col-md-10','col-12 col-md-6');
				TemplateHelper::dt_edit_text(FSText :: _('Ghi chú'),'bank_note',@$data -> bank_note,'','',4,0,0);
				?>
		</div>
	</div>
</div>

<?php 
$this -> dt_form_end(@$data,0);
?>