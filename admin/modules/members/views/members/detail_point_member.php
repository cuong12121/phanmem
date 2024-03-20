<?php $max_ordering = 0; ?>
<input type="hidden" value="<?php echo $_SESSION['ad_username']; ?>" id="ad_username">
<input type="hidden" value="<?php echo date ( 'Y-m-d' ); ?>" id="time_now">
<table cellspacing="1" class="admintable">
	<table cellpadding="5" class="field_tbl" width="100%" border="1" bordercolor="red" style="margin-top: 5px;">
		<tr>
			<th width="20%"> Người sửa</th>
			<th width="20%"> Số điểm</th>
			<th width="40%"> Nội dung</th> 
			<th width="20%"> Thời gian</th>   

		</tr>
		<?php if(!empty($list_changepoint_byadmin)) {?>

			<?php $k = 0; foreach ($list_changepoint_byadmin as $detail) { ?>
				<tr id="ctr<?php echo $k; ?>">
					<td><input type="text" readonly value="<?php echo $detail-> action_username; ?>" name="cusername_<?php echo $k; ?>" id="cusername_<?php echo $k; ?>">
					</td>
					<td><input type="number" readonly value="<?php echo $detail-> value; ?>" name="cvalue_<?php echo $k; ?>" id="cvalue_<?php echo $k; ?>">
					</td>
					<td>
						<textarea readonly rows='4' cols='25' name='cnote_<?php echo $k; ?>' id='cnote_<?php echo $k; ?>' ><?php echo $detail-> note; ?></textarea>
						<!-- <input type="text" value="" name="ctitle_<?php echo $k; ?>" id="ctitle_<?php echo $k; ?>"> -->
					</td>
					<td><input type="text" readonly value="<?php echo $detail-> created_time; ?>" name="ccreated_time_<?php echo $k; ?>" id="ccreated_time_<?php echo $k; ?>">
					</td>
					<input type="hidden" value="<?php echo $detail-> id; ?>" name="cid_<?php echo $k; ?>" id="cid_<?php echo $k; ?>">
				</tr>
				<?php $k++; } ?>
				<input type="hidden" value="<?php echo $k; ?>" name="sumc">
			<?php } ?>
			<?php for( $i = 0 ; $i< 10; $i ++ ) {?>
				<tr id="tr<?php echo $i; ?>" ></tr>
			<?php }?>
			<input type="hidden" value="<?php echo $max_ordering;?>" name="max_ordering" id = "max_ordering" />
		</table>
		<a class='addRecord' href="javascript:void(0);" onclick="addRecord()" > <?php echo FSText :: _("+ Thêm Record"); ?> </a>
	</table>



	<script>
		var i = 0;

		function addRecord()
		{
			max_ordering = $('#max_ordering').val();
			area_id = "#tr"+i;
			ordering = parseInt(max_ordering) + i + 1;
			var user_name = $('#ad_username').val();
			var time = $('#time_now').val();
			var htmlString = '';

        //username 
        htmlString += "<td width='20%'>" ;
        htmlString +=  "<input type=\"text\" class='ipname' value='"+user_name+"'' readonly name='username_"+i+"' id='username_"+i+"'/>";
        htmlString += "</td>";

      //value
      htmlString += "<td width='20%'>" ;
      htmlString +=  "<input type=\"numbber\" name='value_"+i+"' id='value_"+i+"'  />";
      htmlString += "</td>";

      
        //note
        htmlString += "<td width='40%'>" ;
        htmlString +=  " <textarea rows='4' cols='25' name='note_"+i+"' id='note_"+i+"' ></textarea>";
        htmlString += "</td>";

        //time
        htmlString += "<td width='20%'>" ;
        htmlString +=  "<input type=\"text\" value='"+time+"'' readonly name='username_"+i+"' id='time_"+i+"'/>";
        htmlString += "</td>";


      //  alert(htmlString);
      $(area_id).html(htmlString); 
      $("#new_field_total").val(i);
      i++;
  }

  function deletetr(i){
  	$('#tr'+i).remove();
  }


</script>

<style>
.addRecord{
	cursor: pointer;
	background: gray;
	color: #fff !important;
	padding: 6px 10px;
	border-radius: 5px;
	margin-top: 10px !important;
	display: inline-block;
}
th {
	padding: 3px 0px;
	text-align: center;
}
.ipordering {
	/*width: 50px;*/
}
.ipname {
	/*width: 100px;*/
}
input {
	width: 100%;
	line-height: 36px;
	border: 1px solid #afafaf;
	border-radius: 4px;
	padding: 0 10px;
	box-sizing: border-box;
}
textarea {
	width: 100%;
	/*line-height: 36px;*/
	border: 1px solid #afafaf;
	border-radius: 4px;
}
</style>
