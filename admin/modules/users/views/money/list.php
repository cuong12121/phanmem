<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách các tài khoản') );
?>
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post">
		
		<!--	FILTER	-->
		<?php 
			$filter_config  = array();
			$fitler_config['search'] = 1; 
			echo $this -> genarate_filter($fitler_config);
		?>
		<!--	END FILTER	-->
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents" cellpadding="5">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th class="title">
						<?php echo FSText :: _('Username'); ?>
					</th>
					<th class="title">
						<?php echo FSText :: _('Tên'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Số dư hiện tại'), 'money',@$sort_field,@$sort_direct) ; ?>
					</th>
				
					<th class="title" width="10%">
						<?php echo FSText :: _('Nạp tiền'); ?>
					</th>
					<th class="title" width="10%">
						<?php echo FSText :: _('Lịch sử tiêu tiền'); ?>
					</th>
					<th class="title" width="10%">
						<?php echo FSText :: _('Lịch sử nạp tiền'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Id'), 'id',$sort_field,$sort_direct) ; ?>
					</th>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) { ?>
							<?php $link_view = "index.php?module=".$this -> module."&view=".$this -> view."&task=edit&id=".$row->id; ?>
							<?php $link_deposit = "index.php?module=".$this -> module."&view=".$this -> view."&task=deposit&uid=".$row->id; ?>
							<?php $link_hisory_deposit = "index.php?module=".$this -> module."&view=history&type=deposit&uid=".$row->id; ?>
							<?php $link_hisory_buy = "index.php?module=".$this -> module."&view=history&type=buy&uid=".$row->id; ?>
							
							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo $i+1; ?></td>
								<td>
									<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="id[]" id="cb<?php echo $i; ?>">
								</td>
								<td align="left">
									 <?php echo $row -> username; ?>
								</td>
								<td align="left">
									 <?php echo $row -> fname.' '.$row -> mname.' '.$row -> lname; ?>
								</td>
								<td><strong><?php echo format_money($row -> money); ?></strong></td>
								<td><a href="<?php echo $link_deposit;?>">Nạp tiền</a></td>
								<td><a href="<?php echo $link_hisory_buy;?>">Lịch sử tiêu tiền</a></td>
								<td><a href="<?php echo $link_hisory_deposit;?>">Lịch sử nạp tiền</a></td>
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
		
		<input type="hidden" value="<?php echo @$sort_field; ?>" name="sort_field">
		<input type="hidden" value="<?php echo @$sort_direct; ?>" name="sort_direct">
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>