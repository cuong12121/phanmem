<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/eye.js"></script>

<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png');
$toolbar->addButton('save_add',FSText::_('Save & New'),'','save.png');  
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));

	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),100,100,'Kích cỡ ảnh: 200x200px (.png)');
	TemplateHelper::dt_edit_selectbox(FSText::_('Group'),'group_id',@$data -> group_id,0,$groups,$field_value = 'id', $field_label='name',$size = 0,0);
	TemplateHelper::dt_edit_text(FSText :: _('Tóm tắt'),'summary',@$data -> summary,'',100,5,0);

	
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');

	$this -> dt_form_end(@$data,1,0);
?>

<style>

#colorSelector {
    background: url("templates/default/images/select_color.png");
    height: 36px;
    position: relative;
    width: 36px;
}
#colorSelector div {
    background: url("templates/default/images/select_color.png") repeat scroll center center;
    height: 30px;
    left: 3px;
    position: absolute;
    top: 3px;
    width: 30px;
}
</style>
<script type="text/javascript" >
$('#colorSelector').ColorPicker({
	color: '#0000fffa',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('#colorSelector div').css('backgroundColor', '#' + hex);
		$('#color').val( hex );
	}
});
</script>