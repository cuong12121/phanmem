<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/colorpicker/css/colorpicker.css" />
<script>
	$(document).ready(function() {
	    $("#tabs").tabs();
	});
</script>

<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
	$this -> dt_form_begin(0);
?>
	<div id="tabs">
	    <ul>
	        <li><a href="#fragment-1"><span><?php echo FSText::_("Tài khoản đăng nhập"); ?></span></a></li>
	        <li><a href="#fragment-2"><span><?php echo FSText::_("Sơ yếu lý lịch"); ?></span></a></li>
	        <li><a href="#fragment-3"><span><?php echo FSText::_("Công việc"); ?></span></a></li>
	        <li><a href="#fragment-4"><span><?php echo FSText::_("Bảo hiểm"); ?></span></a></li>
	        <li><a href="#fragment-5"><span><?php echo FSText::_("Hợp đồng"); ?></span></a></li>
	        <li><a href="#fragment-6"><span><?php echo FSText::_("Tiếp nhận"); ?></span></a></li>
	        <li><a href="#fragment-7"><span><?php echo FSText::_("Thôi việc"); ?></span></a></li>
	        <li><a href="#fragment-8"><span><?php echo FSText::_("Quản lý các shop"); ?></span></a></li>
	    </ul>
	    <div id="fragment-1">
			<?php include_once 'detail_base.php';?>
		</div>
		<div id="fragment-2">
			<?php include_once 'curriculum_vitae.php';?>
		</div>
		<div id="fragment-3">
			<?php include_once 'work.php';?>
		</div>
		<div id="fragment-4">
			<?php include_once 'insurance.php';?>
		</div>
		<div id="fragment-5">
			<?php include_once 'contract.php';?>
		</div>
		<div id="fragment-6">
			<?php include_once 'receive.php';?>
		</div>
		<div id="fragment-7">
			<?php include_once 'quits_job.php';?>
		</div>

		<div id="fragment-8">
			<?php include_once 'shops.php';?>
		</div>
    </div>
<?php 
$this -> dt_form_end(@$data,0);
?>

<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/css/users.css' ?>" />
<script type="text/javascript" src="<?php echo URL_ROOT.LINK_AMIN.'/modules/'.$this->module.'/assets/js/users.js' ?>"></script>