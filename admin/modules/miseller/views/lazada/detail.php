<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT ?>/libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo URL_ROOT ?>/libraries/jquery/jquery.ui/jquery-ui.js"></script>
<script src="<?php echo URL_ROOT.'libraries/jquery/jsxlsx';?>/shim.min.js"></script>
<script src="<?php echo URL_ROOT.'libraries/jquery/jsxlsx';?>/xlsx.full.min.js"></script>
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
	// $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

if(@$data) {
	$toolbar->addButtonHTML('<a class="toolbar" onclick="export_excel()" href="javascript:void(0)"><span title="Export Excel" style="background:url('.URL_ADMIN.'templates/default/images/toolbar/Excel-icon.png) no-repeat"></span>Export Excel</a>');
}


$this -> dt_form_begin(0);
?>
<div id="tabs">
	<ul>
		<li><a href="#fragment-1"><span><?php echo FSText::_("Trường cơ bản"); ?></span></a></li>

	</ul>

	<div id="fragment-1">
		<?php include_once 'detail_base.php';?>
	</div>

</div>
<?php 
$this -> dt_form_end(@$data,0);
?>