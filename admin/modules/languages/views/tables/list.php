<div class="form_head">
	<?php
	global $toolbar;
	$toolbar -> setTitle(FSText :: _('Item List') ); 
	?>
</div>
<div class="form_body">
	<form action="index.php?module=languages&view=tables" name="adminForm" method="post" >
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						
					</th>
					<th class="title" >
						<?php echo FSText :: _("Name"); ?>
					</th>
					<?php for($i = 0; $i < count($language_not_default);  $i ++ ){?>
						<th class="title" >
							<?php echo ucfirst($language_not_default[$i] -> language); ?>
							<?php if($language_not_default[$i] -> is_default)	echo "(Default)"?>
						</th>
					<?php }?>
						
					<th class="title">
						<?php echo FSText :: _("Id")?>
					</th>
				</thead>
				<tbody>
					<?php $i = 0; ?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) { ?>
							<?php $link_change_language = "index.php?module=languages&view=table&id=".$row->id.""; ?>
							
							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo $i+1; ?></td>
								<td>
									<input type="radio"  value="<?php echo $row->id; ?>"  name="id[]" id="cb<?php echo $i; ?>">
								</td>
								<td>
									<a href="<?php echo $link_change_language; ?>" ><?php echo ucfirst(FSText::_($row->name)); ?></a>
								</td>
								<?php for($j = 0; $j < count($language_not_default);  $j ++ ){?>
								<td>
									<?php $link_synchronization = "index.php?module=languages&view=tables&task=synchronize&id=".$row->id."&syn_lang=".$language_not_default[$j]->lang_sort; ?>
									<?php $link_copy = "index.php?module=languages&view=tables&task=copy&id=".$row->id."&lang=".$language_not_default[$j]->lang_sort; ?>
									<a href="javascript: synchronize('<?php echo $link_synchronization; ?>');"  > <?php echo FSText::_('Synchronize')?></a>
									<?php if($language_not_default[$j] -> is_default){ ?>
									(<a href="<?php echo $link_copy; ?>"  > Copy</a>)
									<?php } ?>
								</td>
								<?php } ?>
								<td><?php echo $row->id; ?></td>
							</tr>
							<?php $i++; ?>
						<?php }?>
					<?php }?>
					
				</tbody>
			</table>
		</div>
		<div class="footer_form">
			<?php if(@$pagination) {?>
			<?php echo $pagination->showPagination();?>
			<?php } ?>
		</div>
		
	</form>
</div>
<script type="text/javascript" >
	function synchronize(link){
		if(confirm("Bạn muốn copy dữ liệu cũ sang để dịch lại.")){
			window.location = link+'&copy=1';
		} else {
			window.location = link+'&copy=0';
		}
	}
</script>