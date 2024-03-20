<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>

<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/eye.js"></script>

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
		<li><a href="#fragment-1"><span><?php echo FSText::_("Tr&#432;&#7901;ng c&#417; b&#7843;n"); ?></span></a></li>
		<li><a href="#fragment-4"><span><?php  echo FSText::_("Giá"); ?></span></a></li>
		
		<!--		        <li><a href="#fragment-2"><span><?php // echo FSText::_("T/s Kỹ thuật"); ?></span></a></li>-->
		<li><a href="#fragment-3"><span><?php echo FSText::_("Ảnh"); ?></span></a></li>
		<li><a href="#fragment-7"><span><?php echo FSText::_("Sp liên quan"); ?></span></a></li>
		
		<!--				<li> <a href="#fragment-10"><span><?php // echo FSText::_("Khuyến mãi"); ?></span></a></li>-->
		<!--				<li><a href="#fragment-11"><span><?php // echo FSText::_("Tin liên quan"); ?></span></a></li>-->
		<li><a href="#fragment-12"><span><?php echo FSText::_("SEO"); ?></span></a></li>
	</ul>
	
	<!--	BASE FIELDS    -->
	<div id="fragment-1">
		<?php include_once 'detail_base.php';?>
	</div>
	<div id="fragment-4">
		<?php include_once 'detail_prices_unit.php';?>
	</div>
	<!--	END BASE FIELDS    -->
	
	<!--	IMAGE FIELDS    -->
	<div id="fragment-3">
		<?php  include_once 'detail_images.php';?>
	</div>
	
	
	<div id="fragment-7">
		<?php include_once 'detail_related.php';?>
	</div>
	<div id="fragment-12">
		<?php include_once 'detail_seo.php';?>
	</div>
	
</div>
<?php 
$this -> dt_form_end(@$data,0);
?>