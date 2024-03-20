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
<div id="tabs">
	<ul>
		<li><a href="#fragment-1"><span><?php echo FSText::_("Thông tin"); ?></span></a></li>
		<li><a href="#fragment-2"><span><?php echo FSText::_("Hình ảnh"); ?></span></a></li>
	</ul>
	<div id="fragment-1">
		<?php include_once 'detail_base.php';?>
	</div>
	<div id="fragment-2">
		<?php include_once 'detail_images.php';?>
	</div>
	
</div>
<?php 
$this -> dt_form_end(@$data,0);
?>

<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/products.css?t='.time(); ?>" />

<script type="text/javascript" src="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/js/products.js?t='.time(); ?>"></script>