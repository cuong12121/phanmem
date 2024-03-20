  <link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui.css" />
<script type="text/javascript" src="templates/default/js/jquery-ui.min.js"></script>
<!-- FOR TAB -->	
<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
//$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
//$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
//$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
	$type = isset($data -> type) ? $data -> type: FSInput::get('type','default');	
	$this -> dt_form_begin(0);
	?>
			<?php include_once 'view_base.php';?>
	   
<input type="hidden" name="type" value="<?php echo $type;?>" />
<input type="hidden" name="news_id" value="<?php echo $data -> news_id;?>" />
<?php 		        	
$this -> dt_form_end(@$data,0);
?>
