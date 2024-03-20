<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>

<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/eye.js"></script>
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

// $this -> dt_form_begin();

// die; 
$this -> dt_form_begin(0);
?>
<div id="tabs">
	<ul>
		<li><a href="#fragment-1"><span><?php echo FSText::_("Thông tin user"); ?></span></a></li>
		<?php if(isset($data)){?>
			<li><a href="#point_member"><span><?php echo FSText::_("Thêm/ bớt điểm"); ?></span></a></li>
			<li><a href="#history_point"><span><?php echo FSText::_("Lịch sử điểm"); ?></span></a></li>
			<li><a href="#orders"><span><?php echo FSText::_("Đơn hàng đặt mua"); ?></span></a></li>
			<li><a href="#orders_affi"><span><?php echo FSText::_("Đơn hàng Affiliate"); ?></span></a></li> 
		<?php }?>
	</ul>
	<!--	BASE FIELDS    -->
	<div id="fragment-1">
		<?php include_once 'detail_base.php';?>
	</div>
	<!--	END BASE FIELDS    -->
	<?php if(isset($data)){?>
		<div id="point_member">
			<?php include_once 'detail_point_member.php';?>
		</div>
		<div id="history_point">
			<?php  include_once 'history_point.php';?>
		</div>
		<div id="orders">
			<?php  include_once 'orders.php';?>
		</div>
		<div id="orders_affi">
			<?php include_once 'orders_affi.php';?>
		</div> 

	<?php } ?>

</div>
<?php 
$this -> dt_form_end(@$data,0);
?>

