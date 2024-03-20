  <link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui-1.7.3.custom.css" />
<script type="text/javascript" src="templates/default/js/jquery-ui-1.7.3.custom.min.js"></script>
<!-- FOR TAB -->	

<!-- HEAD -->
	
	<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
//	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
//	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<div id="msg_error"></div>
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
			<!--	BASE FIELDS    -->
		    <div id="fragment-1">
				<?php include_once 'detail_base.php';?>
			</div>
		    <!--	END BASE FIELDS    -->
		     
		</div>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
<!-- END BODY-->

