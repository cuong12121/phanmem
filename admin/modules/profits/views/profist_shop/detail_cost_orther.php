<?php $max_ordering = 1;
$i=0; ?>
	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
		<thead>
			<tr>
				<th align="center" >
					<?php echo FSText :: _('Tên chi phí'); ?>
				</th>
				<th align="center"  width="50%">
					<?php echo FSText :: _('Số tiền'); ?>
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
                    <input type="text" size="60" value="<?php echo $item -> title; ?>" name="days_title_exist_<?php echo $i;?>"/>
				</td>
				<td>
					 <input type="text" size="60" value="<?php echo $item -> money; ?>" name="days_money_exist_<?php echo $i;?>"/>
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
			<tr id='new_videoss_<?php echo $i?>' class='new_record closed'>
                <td>
					<input type="text" size="60" id="new_days_title_<?php echo $i;?>" name="new_days_title_<?php echo $i;?>"/>
				</td>

				<td>
					<input type="text" size="60" id="new_days_money_<?php echo $i;?>" name="new_days_money_<?php echo $i;?>"/>
				</td>
				
				<td>
					<input type="checkbox" onclick="remove_days(this.checked);"  name="other_days[]" id="other_days<?php echo $i; ?>" />
				</td>
			</tr>
		<?php } ?>
	</tbody>		
	</table>
	<div class='add_record'>
		<a href="javascript:add_video()"><strong class='red'><?php echo FSText :: _('Thêm phí'); ?></strong></a>
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
function add_video(){
	for(var i = 0; i < 20; i ++){
		tr_current = $('#new_videoss_'+i);
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