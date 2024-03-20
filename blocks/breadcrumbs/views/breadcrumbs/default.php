<?php
global $tmpl; 
$tmpl -> addScript('breadcrumbs','blocks/breadcrumbs/assets/js');
?>	
<?php if(isset($breadcrumbs)){?>
<div class='breadcrumb'>
	<div class='breadcumbs-first'><a href="<?php echo URL_ROOT?>"><img src="<?php echo URL_ROOT.'templates/default/images/icon-home.png';?>" align="home" /></a></div>
	<?php $i = 0; ?>
	<?php if(count($breadcrumbs)){?>
		<?php foreach($breadcrumbs as $item){?>
			<div class='breadcrumbs_sepa'><img src="<?php echo URL_ROOT.'templates/default/images/icon-pathway.png';?>" align="icon-path" /></div>
			<select name="breadcrumb_item breadcrumb_<?php echo $i?>" class="breadcrumb_item breadcrumb_<?php echo $i?>">
				<?php if(count($item)){?>
					<?php foreach($item as $cat_item){?>
						<option value="<?php echo $cat_item ['link'];?>" <?php  echo $cat_item['selected'] ?"selected='selected'":""; ?> ><?php echo $cat_item ['name'];?></option>
					<?php }?>
				<?php }?>
			</select>
			<?php $i ++;?>								
		<?php }?>
	<?php }?>	
<div class="clear"></div>
</div>
<?php }?>