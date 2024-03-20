
<!-- HEAD -->
<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>

<?php $key_config =FSInput::get("key",''); ?>

<?php 
// return;
$i=0;
foreach ($group as $itemg) { ?>
	<?php foreach($data_g[$itemg-> id] as $item) {
		if($item-> name == $key_config) $group_active = $i; 
	} ?>
	<?php $i++; } ?>

	<script>
		$(document).ready(function() {
			$("#tabs").tabs({
				active: <?php echo @$group_active?$group_active:0; ?>
			});
		});
	</script>
	<?php 
	$title = FSText :: _('Configuration'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');
	$this -> dt_form_begin(1,4,$title);
	?>   

	<div id="tabs">
		<ul>
			<?php $i=0; foreach ($group as $itemg) { ?>

				<li><a href="#fragment-<?php echo $i; ?>" class="a_fragment_<?php echo $itemg-> id; ?>"><span><?php echo $itemg-> name; ?></span></a></li>
				<?php $i++; } ?>

				<li><a href="#fragment-<?php echo $i; ?>" class="a_fragment_other"><span>Thông tin khác</span></a></li>
			</ul>
			<?php $i=0; foreach ($group as $itemg) { ?>
				<div id="fragment-<?php echo $i; ?>">
					<?php foreach($data_g[$itemg-> id] as $item) {?>
						<div class="form-group <?php if($item-> name == $key_config) {$group_active = $i; echo "config_active";}?>" id="config_<?php echo $item-> id; ?>">
							<label class="col-sm-2 col-xs-12 control-label"><?php echo FSText::_($item->title); ?></label>
							<div class="col-sm-9 col-xs-12">
								<?php 
								switch ($item->data_type) {
									case "text":
									default:
									echo "<input class='form-control' type='text' name='$item->name' value='$item->value' size='70' /> ";
									break;
									case 'textarea':
									echo "<textarea class='form-control' cols='70' name='$item->name'>$item->value</textarea>";
									break;	
									case "bool":
									if($item->value == 1)
									{
										$checktrue = " checked = 'checked' ";	
										$checkfalse = "";
									}
									else
									{
										$checkfalse = " checked = 'checked' ";	
										$checktrue = "";
									}
									echo "<input type='radio' name='$item->name' $checktrue value='1'  /> ".FSText::_('Yes');
									echo "<input type='radio' name='$item->name' $checkfalse value='0' />".FSText::_('No');
									break;	
									case "image":
									if($item -> value){
										echo '<img width="120px" src="'.URL_ROOT.$item -> value.'" />';
									}
									echo '
									<div class="fileUpload btn btn-primary ">
									<span><i class="fa fa-cloud-upload"></i> Upload</span>
									<input type="file" class="upload" name="'.$item->name.'"  />
									</div>';
									break;
									case "editor":
									$oFCKeditor = new FCKeditor("$item->name") ;
									$oFCKeditor->BasePath	=  '../libraries/wysiwyg_editor/' ;
									$oFCKeditor->Value		= @$item->value;
									$oFCKeditor->Width = 650;
									$oFCKeditor->Height = 450;
									$oFCKeditor->Create() ;
									break;
								}
								?>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php $i++; } ?>

				<div id="fragment-<?php echo $i; ?>">
					<?php foreach($data_g['other'] as $item) {?>
						<div class="form-group <?php if($item-> name == $key_config) {$group_active = $i; echo "config_active";}?>" id="config_<?php echo $item-> id; ?>">
							<label class="col-sm-2 col-xs-12 control-label"><?php echo FSText::_($item->title); ?></label>
							<div class="col-sm-9 col-xs-12">
								<?php 
								switch ($item->data_type) {
									case "text":
									default:
									echo "<input class='form-control' type='text' name='$item->name' value='$item->value' size='70' /> ";
									break;
									case 'textarea':
									echo "<textarea class='form-control' cols='70' name='$item->name'>$item->value</textarea>";
									break;	
									case "bool":
									if($item->value == 1)
									{
										$checktrue = " checked = 'checked' ";	
										$checkfalse = "";
									}
									else
									{
										$checkfalse = " checked = 'checked' ";	
										$checktrue = "";
									}
									echo "<input type='radio' name='$item->name' $checktrue value='1'  /> ".FSText::_('Yes');
									echo "<input type='radio' name='$item->name' $checkfalse value='0' />".FSText::_('No');
									break;	
									case "image":
									if($item -> value){
										echo '<img width="120px" src="'.URL_ROOT.$item -> value.'" />';
									}
									echo '
									<div class="fileUpload btn btn-primary ">
									<span><i class="fa fa-cloud-upload"></i> Upload</span>
									<input type="file" class="upload" name="'.$item->name.'"  />
									</div>';
									break;
									case "editor":
									$oFCKeditor = new FCKeditor("$item->name") ;
									$oFCKeditor->BasePath	=  '../libraries/wysiwyg_editor/' ;
									$oFCKeditor->Value		= @$item->value;
									$oFCKeditor->Width = 650;
									$oFCKeditor->Height = 450;
									$oFCKeditor->Create() ;
									break;
								}
								?>
							</div>
						</div>
					<?php } ?>
				</div>

			</div>
	<?php    
	$this -> dt_form_end(@$data,1,0); 
	?>


