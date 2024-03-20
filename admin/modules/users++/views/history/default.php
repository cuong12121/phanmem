<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách') );
?>
<div class="form_body">
	<form name="adminForm"  action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>&type=<?php echo $type; ?>" method="post">
		<div align = right>
		<!--	FILTER	-->
			<b>Dịch vụ:</b> 
		
			<select name="service">
			<option value ="">--Dịch vụ--</option>
			<?php
			$total_service_list = count($service);
						if($total_service_list){
							for($i = 0; $i < $total_service_list; $i ++){
								$checked = "";
								$item_service = $service[$i];
								if($item_service->service_name == @$_SESSION[$this -> prefix.'service'])
											$checked = " selected=\"selected\"";
									?>
								<option value="<?php echo $item_service->service_name; ?>" <?php echo $checked;?>>
									<?php echo $item_service->service_name;
								echo "</option>";
							}
						}
			?>
			</select>

			<input type ="submit" value ="Tìm kiếm" />
			</div>
		<!--	END FILTER	-->
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents" cellpadding="5">
				<thead>
					<tr>
						<th width="10%">
							STT
						</th>
						<th width="20%" class="title">
							<?php echo  TemplateHelper::orderTable(FSText :: _('Thời gian'), 'created_time',@$sort_field,@$sort_direct) ; ?>
						</th>
						<th width="20%" class="title">
							<?php echo  TemplateHelper::orderTable(FSText :: _('Số tiền'), 'money',@$sort_field,@$sort_direct) ; ?>
						</th>
						<th  class="title">
							<?php echo  TemplateHelper::orderTable(FSText :: _('Dịch vụ'), 'service_name',@$sort_field,@$sort_direct) ; ?>
						</th>
					</tr>
				</thead>
				<tbody>
					
				
				<?php 	
					$total_users_list = count($list);
						if($total_users_list){
							for($i = 0; $i < $total_users_list; $i ++){
								$item = $list[$i];
								?>	
								<tr class="row<?php echo $i%2; ?>">
									<th>
										<?php echo $i+1; ?>
									</th>
									<th>
										<?php echo date('H:i d/m/Y',strtotime($item->created_time)); ?>
									</th>
									<th>
										<?php echo format_money($item->money); ?>
									</th>
									<th>
									<?php echo $item->service_name; ?>
									</th>
									<?php }}?>
									
					</tr>
				</tbody>
			</table>
		</div>
		<div class="footer_form">
			<?php if(@$pagination) {?>
			<?php echo $pagination->showPagination();?>
			<?php } ?>
		</div>
		
			<input type="hidden" value="<?php echo @$sort_field; ?>" name="sort_field">
			<input type="hidden" value="<?php echo @$sort_direct; ?>" name="sort_direct">
			<input type="hidden" value="<?php echo $this -> module;?>" name=user>
			<input type="hidden" value="<?php echo $this -> view;?>" name="history">
	</form>
</div>