<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/eye.js"></script>

<?php 
$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
$this -> dt_form_begin();
TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
?>
	<tr>
		<td class="label key" valign="top"><?php echo FSText :: _('Mã màu');?></td>
		<td class="value">
			<div id="colorSelector"><div style="background-color: <?php echo ($data -> code)?'#'.$data -> code:'#0000ff';?>"></div></div>
			<input id="code" type="hidden" value="<?php echo @$data -> code;?>" name="code" />
		</td>
	</tr>

	<?php
TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
$this -> dt_form_end(@$data, 1, 0);
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
	color: '#0000ff',
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
		$('#code').val( hex );
	}
});
</script>