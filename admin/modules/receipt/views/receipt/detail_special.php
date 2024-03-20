<?php $max_ordering = 1;
$i=0; ?>
	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
		<thead>
			<tr>
				<th align="center" >
					<?php echo FSText :: _('Thông tin'); ?>
				</th>
				<th align="center"  width="15">
					<?php echo FSText :: _('Remove'); ?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if(isset($days) && !empty($days)){
				foreach ($days as $item) { 
		?>
			<tr>
                <td>
					<input type="hidden" value="<?php echo $item -> id; ?>" name="id_days_exist_<?php echo $i;?>"/>	
                    <input type="text" size="20" value="<?php echo $item -> source; ?>" name="days_name_exist_<?php echo $i;?>"/>
					<input type="hidden" value="<?php echo mysql_real_escape_string($item -> source); ?>" name="days_name_exist_<?php echo $i;?>_original"/>
				</td>
				<td>
					<input type="checkbox" onclick="remove_days(this.checked);" value="<?php echo $item->id; ?>"  name="other_days[]" id="other_days<?php echo $i; ?>" />
				</td>
			</tr>
				<?php
                $i++;
				}
			}
			?>
		<?php for($i = 1; $i < 20; $i ++ ) { ?>
			<tr id='new_days_<?php echo $i?>' class='new_record closed'>
                
		
                 <td>
					 <input type="text" size="20" id="new_days_name_<?php echo $i;?>" name="new_days_name_<?php echo $i;?>"/>
				 </td>
				<td>
					<input type="checkbox" onclick="remove_days(this.checked);"   name="other_days[]" id="other_days<?php echo $i; ?>" />
				</td>
			</tr>
	<?php } ?>
	</tbody>		
	</table>
	<div class='add_record'>
		<a href="javascript:add_days()"><strong class='red'><?php echo FSText :: _('Thêm dòng thông tin'); ?></strong></a>
	</div>
	<input type="hidden" value="<?php echo isset($days)?count($days):0; ?>" name="days_exist_total" id="days_exist_total" />
	
<script type="text/javascript" >
function remove_days(isitchecked){
	if (isitchecked == true){
		document.adminForm.otherdays_remove.value++;
	}
	else {
		document.adminForm.otherdays_remove.value--;
	}
}
function add_days(){
	for(var i = 0; i < 20; i ++){
		tr_current = $('#new_days_'+i);
		if(tr_current.hasClass('closed')){
			tr_current.addClass('opened').removeClass('closed');
			return;
		}
	}
}
</script>
<style>
.closed{
	display:none;
}
</style>