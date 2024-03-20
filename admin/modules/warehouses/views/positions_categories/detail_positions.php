<?php 
$limit_default = 5;
$max_ordering = 0; ?>
<table cellpadding="5" class="table table-hover table-striped table-bordered" width="100%" border="1" bordercolor="#888888" style="margin-top: 5px;">
	<tr>
		<th width="15%">Tên vị trí</th>
		<th width="15%">Mã</th>
		<th width="15%">Mã vị trí</th>
		<th width="15%">Mã vạch</th>
		<th width="15%">Số lượng nhập tối đa</th>   
		<th width="15%">Số lượng đã nhập</th>
		<th width="10%" class="delete"> Xóa</th>
	</tr>
	<?php if(!empty($list_positions)) {?>
		<?php $k = 0; foreach ($list_positions as $position) { ?>
			<tr id="ctr<?php echo $k; ?>">
				<td><input type="text" value="<?php echo $position-> name; ?>" name="cname_position_<?php echo $k; ?>" id="cname_position_<?php echo $k; ?>">
				</td>
				<td><input type="text" value="<?php echo $position-> code; ?>" name="ccode_position_<?php echo $k; ?>" id="ccode_position_<?php echo $k; ?>">
				</td>
				<td><input type="text" readonly disabled value="<?php echo $position-> list_code; ?>"></td>
				<td><input type="text" value="<?php echo $position-> barcode; ?>" name="cbarcode_position_<?php echo $k; ?>" id="cbarcode_position_<?php echo $k; ?>">
				</td>
				<td><input type="number" value="<?php echo $position-> limit; ?>" name="climit_position_<?php echo $k; ?>" id="climit_position_<?php echo $k; ?>">
				</td>
				<td><input type="text" readonly disabled value="<?php echo $position-> amount?$position-> amount:0; ?>"></td>
				<!-- <td><?php echo $position-> amount?$position-> amount:0; ?></td> -->
				<td class="delete"><input type="button" value="Xóa" onclick="cdelecte(<?php echo $position-> id; ?> , <?php echo $k; ?>)" id="cdelete_<?php echo $position-> id; ?>"></td>
				<input type="hidden" value="<?php echo $position-> id; ?>" name="cid_<?php echo $k; ?>" id="cid_<?php echo $k; ?>">
			</tr>
			<?php $k++; } ?>
			<input type="hidden" value="<?php echo $k; ?>" name="sumc">
		<?php } ?>
		<?php for( $i = 0 ; $i< $limit_default; $i ++ ) {?>
			<tr id="ptr<?php echo $i; ?>" >
				<td><input type="text" placeholder="Tên vị trí" name="name_position_<?php echo $i; ?>" id="name_position_<?php echo $i; ?>"></td>
				<td><input type="text" placeholder="Mã" name="code_position_<?php echo $i; ?>" id="code_position_<?php echo $i; ?>"></td>
				<td>&nbsp;</td>
				<td><input type="text" placeholder="Mã vạch" name="barcode_position_<?php echo $i; ?>"  id="barcode_position_<?php echo $i; ?>"></td>
				<td><input type="number" placeholder="Số lượng nhập tối đa" min="1" name="limit_position_<?php echo $i; ?>" id="limit_position_<?php echo $i; ?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php $max_ordering++; }?>
			<?php for( $i = $limit_default ; $i< 100; $i ++ ) {?>
				<tr id="ptr<?php echo $i; ?>" ></tr>
			<?php }?>

			<input type="hidden" value="<?php echo $max_ordering;?>" name="pmax_ordering" id = "pmax_ordering" />
		</table>
		<a class='addRecord btn btn-primary' style="color: #fff;" href="javascript:void(0);" onclick="addRecord2()" > <?php echo FSText :: _("+ Thêm Record"); ?> </a>


		<script>
			var i = <?php echo $limit_default; ?>;

			function addRecord2()
			{
				max_ordering = $('#pmax_ordering').val();
				area_id = "#ptr"+i;
			// alert(area_id);
			ordering = parseInt(max_ordering) + i + 1;
			var htmlString = '';

        //username 
        htmlString += "<td>" ;
        htmlString +=  "<input type=\"text\" placeholder='Tên vị trí' name='name_position_"+i+"' id='name_position_"+i+"'/>";
        htmlString += "</td>";

      //value
      htmlString += "<td>" ;
      htmlString +=  "<input type=\"text\" placeholder='Mã' name='code_position_"+i+"' id='code_position_"+i+"'  />";
      htmlString += "</td>";

                  htmlString += "<td>&nbsp;" ;
            htmlString += "</td>";

            //value
            htmlString += "<td>" ;
            htmlString +=  "<input type=\"text\" placeholder='Mã vạch' name='barcode_position_"+i+"' id='barcode_position_"+i+"'  />";
            htmlString += "</td>";
            //value
            htmlString += "<td>" ;
            htmlString +=  "<input type=\"number\" placeholder='Số lượng nhập tối đa' name='limit_position_"+i+"' id='limit_position_"+i+"'  />";
            htmlString += "</td>";

            htmlString += "<td>&nbsp;" ;
            htmlString += "</td>";

            htmlString += "<td width='5%' class='delete'>" ;
            htmlString +=  "<input type=\"button\" value='Xóa' onclick='deletetr(\""+i+"\")' id='delete_"+i+"'/>";
            htmlString += "</td>";

      //  alert(htmlString);
      // alert(area_id);
      $(area_id).html(htmlString); 
      // $("#new_field_total").val(i);
      i++;
}

function deletetr(i){
	$('#tr'+i).remove();
}

function cdelecte(i,k) {
	var r = confirm("Bạn có chắc muốn xóa bản ghi này?!");
	if (r == true) {
		$('#ctr'+k).remove();
		$.ajax({
			type : 'get',
			url : '<?php echo URL_ADMIN; ?>/index.php?module=warehouses&view=positions_categories&raw=1&task=cdelete',
			dataType : 'html',
			data: {id:i},
			success : function(data){
      		//$('#editor_des_'+i).html(data);
      	},
      	error : function(XMLHttpRequest, textStatus, errorThrown) {}
      });   
	} else {
	}

}


</script>

<style>
	#fragment-2 input{
		max-width: 150px;
	}
</style>