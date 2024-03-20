<link href="templates/default/css/templates.css" rel="stylesheet" type="text/css" />
<div class="form_body">
	<div class="filter_area">
		<table>
			<tbody>
				<tr>
					<td align="left">
						Tìm kiếm:
						<input id="search_create_link" class="text_area" type="text" value="<?php echo isset($_SESSION['menu_ceate_link']) ? $_SESSION['menu_ceate_link'] : '' ?>" name="keysearch">
					</td>
					<td>
						<button onclick="set_seetion_search()">Tìm kiếm</button>
						<button onclick="reset_seetion_search()">Reset</button>
					</td>
					</tr>
				</tbody>
		</table>
	</div>
	<form action="#" name="linkedForm" method="get">
		<div class='contents'>
			<table border="1" class="tbl_form_contents" width="100%">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th class="title">
						<?php echo ucfirst($field_display); ?>
					</th>
					
					
					<?php foreach($arr_field_value as $field_one){?>
						<?php if($field_display != $field_one){?>	
					<th class="title" width="7%">
						<?php echo ucfirst($field_one); ?>
					</th>
						<?php }?>
					<?php }?>
					<th class="title">
						<?php echo FSText :: _('Add Link'); ?>
					</th>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php foreach ($list as $row) { ?>
						<?php $str_value_in_record = '';?>
						<tr class="row<?php echo $i%2; ?>">
							<td><?php echo $i+1; ?></td>
							<td><?php echo $row->$field_display; ?></td>
							<?php $j = 0;?>
							<?php foreach($arr_field_value as $field_one){?>
							<?php if($field_display != $field_one){?>
								<?php if($j > 0) $str_value_in_record .= ',';?>
								<?php $str_value_in_record .= $row->$field_one;?>					
							<td >
								<?php echo $row->$field_one; ?>
							</td>
								<?php $j ++;?>
							<?php }?>
							<?php }?>
							<td><a href="javascript: add_param('<?php echo $str_value_in_record; ?>')" >Create link</a></td>
						</tr>
						<?php $i++; ?>
					<?php }?>
					
				</tbody>
			</table>
			
		</div>
		<div class="footer_form">
			<?php echo $pagination->showPagination();?>
		</div>
	
		<input type="hidden" value="menus" name="module">
		<input type="hidden" value="add_param" name="task">
		<input type="hidden" value="items" name="view">
	</form>
</div>
<?php echo $add_param ?>
<script type="text/javascript">
    
	param = '<?php echo $add_param;?>';
	arr_param = param.split(',');
	function add_param(value){
		arr_value = value.split(',');
		str_uri = '';
		for(i = 0; i < arr_param.length; i ++){
			str_uri += '&'+arr_param[i]+'='+arr_value[i];
		}
		window.opener.document.getElementById("link").value += str_uri;
		window.close();
	}
	function set_seetion_search() {
		var key = $("#search_create_link").val();
		$.ajax({url: "index.php?module=menus&view=items&task=ajax_set_seetion_search&raw=1",
			data: {key: key},
			dataType: "text",
			success: function(data) {
				if(data == 1){
					location.reload();
				}else{
					alert("Có lỗi xảy ra !");
				}
			}
		});
	}

	function reset_seetion_search() {
		$.ajax({url: "index.php?module=menus&view=items&task=ajax_reset_seetion_search&raw=1",
			dataType: "text",
			success: function(data) {
				if(data == 1){
					location.reload();
				}else{
					alert("Có lỗi xảy ra !");
				}
			}
		});
	}
</script>