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
		<li><a href="#fragment-2"><span><?php echo FSText::_("Tr&#432;&#7901;ng m&#7903; r&#7897;ng"); ?></span></a></li>
		<li><a href="#fragment-21"><span><?php echo FSText::_("Thêm giá khác"); ?></span></a></li>
		<!-- <li><a href="#fragment-7"><span><?php //echo FSText::_("Màu sản phẩm"); ?></span></a></li> -->
		<li><a href="#fragment-3"><span><?php echo FSText::_("Ảnh"); ?></span></a></li>
		<!-- <li><a href="#fragment-6"><span><?php echo FSText::_("Bộ nhớ"); ?></span></a></li> -->
		<!-- <li><a href="#fragment-9"><span><?php echo FSText::_("Bảo hành"); ?></span></a></li> -->
		<!-- <li><a href="#fragment-12"><span><?php echo FSText::_("Nguồn gốc"); ?></span></a></li>  -->
		<!-- <li><a href="#fragment-13"><span><?php echo FSText::_("RAM"); ?></span></a></li>  -->
		<!-- <li><a href="#fragment-15"><span><?php echo FSText::_("Trạng thái SD"); ?></span></a></li> -->
		<!-- <li><a href="#fragment-17"><span><?php echo FSText::_("Khu vực"); ?></span></a></li> -->
		<li><a href="#fragment-8"><span><?php echo FSText::_("Sp liên quan"); ?></span></a></li>
		<!-- <li><a href="#fragment-10"><span><?php echo FSText::_("Mua kèm giảm giá"); ?></span></a></li> -->
		<!-- <li><a href="#fragment-14"><span><?php echo FSText::_("D/v sửa chữa"); ?></span></a></li> -->
		<li><a href="#fragment-11"><span><?php echo FSText::_("Tin liên quan"); ?></span></a></li>
		<!-- <li><a href="#fragment-18"><span><?php echo FSText::_("Mua trả góp"); ?></span></a></li> -->
		<!-- <li><a href="#fragment-16"><span><?php echo FSText::_("Landing"); ?></span></a></li> -->
		<!-- <li><a href="#fragment-19"><span><?php echo FSText::_("SP So sánh"); ?></span></a></li> -->
		<!-- <li><a href="#fragment-20"><span><?php echo FSText::_("Slide nổi bật"); ?></span></a></li> -->
	</ul>

	<!--	BASE FIELDS    -->
	<div id="fragment-1">
		<?php include_once 'detail_base.php';?>
	</div>
	<!--	IMAGE FIELDS    -->
	<div id="fragment-2">
		<?php include_once 'detail_extend.php';?>
	</div>
	<!--	end detail_extend_price  FIELDS    -->

	<div id="fragment-21">
		<?php include_once 'detail_extend_price.php';?>
	</div>

	<!--	IMAGE FIELDS    -->
	<div id="fragment-3">
		<?php  include_once 'detail_images.php';?>
	</div>		

	<div id="fragment-20">
		<?php include_once 'detail_slideshow_highlight.php';?>
	</div>	

	<div id="fragment-6">
		<?php //include_once 'detail_memory.php';?>
	</div>
	<div id="fragment-12">
		<?php //include_once 'detail_origin.php';?>
	</div>
	<div id="fragment-13">
		<?php //include_once 'detail_species.php';?>
	</div>
<!-- 	<div id="fragment-7">
		<?php //include_once 'detail_color.php';?>
	</div> -->
	<div id="fragment-9">
		<?php //include_once 'detail_warranty.php';?>
	</div>
	<div id="fragment-15">
		<?php //include_once 'detail_usage_states.php';?>
	</div>
	<div id="fragment-17">
		<?php //include_once 'detail_regions.php';?>
	</div>
	<div id="fragment-8">
		<?php include_once 'detail_related.php';?>
	</div>
	<div id="fragment-10">
		<?php //include_once 'detail_compatable.php';?>
		<?php //include_once 'detail_incentives.php';?>
		
	</div>
	<div id="fragment-11">
		<?php include_once 'detail_news_related.php';?>
	</div>
	<div id="fragment-14">
		<?php //include_once 'detail_service.php';?>
	</div>
	<div id="fragment-18">
		<?php //include_once 'detail_installment.php';?>
	</div>
<!-- 	<div id="fragment-16">
		<?php // include_once 'detail_landingpage.php';?>
	</div> -->
	<div id="fragment-19">
		<?php //include_once 'detail_compare.php';?>
	</div>

</div>
<?php 
$this -> dt_form_end(@$data,0);
?>