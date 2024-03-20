<?php $max_ordering = 1;
$i=0; ?>
	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
		<thead>
			<tr>
				<th align="center" >
					<?php echo FSText :: _('Hợp đồng'); ?>
				</th>
				<th align="center" >
					<?php echo FSText :: _('Ký số'); ?>
				</th>
				<th align="center" >
					<?php echo FSText :: _('Ngày ký'); ?>
				</th>
				<th align="center" >
					<?php echo FSText :: _('Ngày bắt đầu'); ?>
				</th>
				<th align="center" >
					<?php echo FSText :: _('Ngày kết thúc'); ?>
				</th>
				<th align="center" >
					<?php echo FSText :: _('File hợp đồng'); ?>
				</th>
				<th align="center"  width="15">
					<?php echo FSText :: _('Remove'); ?>
				</th>
			</tr>
		</thead>
		<tbody>

		<?php
			if(isset($contracts) && !empty($contracts)){
				foreach ($contracts as $item) { 
		?>
			<tr>
                <td>
					<input type="hidden" value="<?php echo $item -> id; ?>" name="exist_contract_id_<?php echo $i;?>"/>	
                    <input type="text" size="20" value="<?php echo $item -> name; ?>" name="exist_contract_name_<?php echo $i;?>"/>
				</td>
				<td>
					<input type="text" size="20"value="<?php echo $item -> signature; ?>"  id="exist_contract_signature_<?php echo $i;?>" name="exist_contract_signature_<?php echo $i;?>"/>
				</td>
				<td>
					<input type="text" size="20" value="<?php echo date('d-m-Y',strtotime($item -> date_signature)) ?>" class="date_class" id="exist_contract_date_signature_<?php echo $i;?>" name="exist_contract_date_signature_<?php echo $i;?>"/>
				</td>
				<td>
					<input type="text" size="20" value="<?php echo date('d-m-Y',strtotime($item -> date_start)); ?>" class="date_class" id="exist_contract_date_start_<?php echo $i;?>" name="exist_contract_date_start_<?php echo $i;?>"/>
				</td>
				<td>
					<input type="text" size="20" value="<?php echo date('d-m-Y',strtotime($item -> date_end)); ?>" class="date_class" id="exist_contract_date_end_<?php echo $i;?>" name="exist_contract_date_end_<?php echo $i;?>"/>
				</td>
				<td>

					<input type="file" name="exist_contract_file_<?php echo $i;?>">
					<?php if($item -> file){ ?>
					<a href="<?php echo URL_ROOT.$item -> file ?>" ><i class="fa fa-download"></i>Tải file</a>
					<?php } ?>
				</td>
				<td>
					<input type="checkbox" onclick="remove_contract(this.checked);" value="<?php echo $item->id; ?>"  name="other_contracts[]" id="other_contracts<?php echo $i; ?>" />
				</td>
			</tr>
				<?php
                $i++;
				}
			}
		?>

		<?php for($i = 1; $i < 20; $i ++ ) { ?>
			<tr id='new_contract_<?php echo $i?>' class='new_record closed'>
                <td>
					<input type="text" size="20" id="new_contract_name_<?php echo $i;?>" name="new_contract_name_<?php echo $i;?>"/>
				</td>
				<td>
					<input type="text" size="20" id="new_contract_signature_<?php echo $i;?>" name="new_contract_signature_<?php echo $i;?>"/>
				</td>
				<td>
					<input type="text" size="20" class="date_class" id="new_contract_date_signature_<?php echo $i;?>" name="new_contract_date_signature_<?php echo $i;?>"/>
				</td>
				<td>
					<input type="text" size="20" class="date_class" id="new_contract_date_start_<?php echo $i;?>" name="new_contract_date_start_<?php echo $i;?>"/>
				</td>
				<td>
					<input type="text" size="20" class="date_class" id="new_contract_date_end_<?php echo $i;?>" name="new_contract_date_end_<?php echo $i;?>"/>
				</td>
				<td>
					<input type="file" name="new_contract_file_<?php echo $i;?>">
				</td>
				<td>
					<input type="checkbox" onclick="remove_contract(this.checked);"  name="other_contracts[]" id="other_contracts<?php echo $i; ?>" />
				</td>
			</tr>
		<?php } ?>

		
		
	</tbody>		
	</table>
	<div class='add_record'>
		<a href="javascript:add_contract()"><strong class='red'><?php echo FSText :: _('Thêm hợp đồng'); ?></strong></a>
	</div>
	<input type="hidden" value="<?php echo isset($contracts)?count($contracts):0; ?>" name="contract_exist_total" id="contract_exist_total" />
	
<script type="text/javascript" >
	function remove_contract(isitchecked){
		if (isitchecked == true){
			document.adminForm.otherdays_remove.value++;
		}
		else {
			document.adminForm.otherdays_remove.value--;
		}
	}
	function add_contract(){
		for(var i = 0; i < 20; i ++){
			tr_current = $('#new_contract_'+i);
			if(tr_current.hasClass('closed')){
				tr_current.addClass('opened').removeClass('closed');
				return;
			}
		}
	}
	$(function() {
		$(".date_class").datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
	});
</script>
<style>
.closed{
	display:none;
}
</style>



