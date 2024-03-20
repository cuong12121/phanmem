<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Cập nhật sản phẩm từ phần mềm') );
?>
<div class="form_body">
	<p>Bạn hãy click vào button dưới đây để cập nhật sản phẩm từ phần mềm</p>
	<br/>
	<p><input type="button" onclick="javscript: window.location='index.php?module=update&view=update&task=save'; " value="Cập nhật sản phẩm"/></p>
	<br/>
	<?php if(isset($arr_result)){?>
		<p>Đã có <strong class='red'><?php echo count($arr_result)?></strong> sản phẩm được cập nhật từ phần mềm.</p>
		<br/>
		<p>Danh sách các sản phẩm đã câp nhật:<p>
		
		<table border="1" class="tbl_form_contents" cellpadding="5" bordercolor="#CCC">
				<thead>
					<tr>
						<th width="5%">
							STT
						</th>
						<th width="50%">
							Tên sản phẩm
						</th>
						<th class="title">
							Id
						</th>
						<th class="title" width="7%">
							Xem
						</th>
					</tr>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
						<?php foreach ($arr_result as $row) { ?>
						  
							<?php $link_detail = "index.php?module=products&view=products&task=edit&id=".$row['id']; ?>
							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo $i+1; ?>
								</td>
								<td>
									<?php echo $row['name'];?>
								</td>
								<td>
									<?php echo $row['id'];?>
								</td>
								<td><a href="<?php echo $link_detail; ?>" target="_blink">Xem</a> </td>
							</tr>
							<?php $i++; ?>
						<?php }?>
				</tbody>
			</table>
	<?php }?>
</div>
